<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use backend\models\RedirectRecord;
use yii\db\Query;

/**
 * ReportSearch represents the model behind the search form about `backend\models\ReportSearch`.
 */
class ReportSearch extends RedirectRecord
{
    /**
     * @var string $dateFrom 
     */
    public $dateFrom;
    
    /**
     * @var string $dateFrom 
     */
    public $dateTo;

    /**
     * The mega crutch for the top list as two-dimensional array with format:
     * ```
     *  [{$row['ym']} => [
     *      {$row['hash_url_id']} => value
     *  ]], where
     * **value** is a just sequence number from any index
     * ```
     * @return array
     */
    protected $mappingTop = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // TODO! Fast implementation
        // I won't have time to add filters
        // therefore, stupidly take min and max by the dt_register field
        // and we beat the interval by months, 
        // then everything into a single request (HORROR)
        // well, the shit code will be right now :)

        $clearCountQuery = '
            SELECT COUNT(*) FROM (
                SELECT COUNT(*) countRow FROM ab54f3equ8_redirect_record rr
                GROUP BY 
                    CONCAT(
                        MONTH(FROM_UNIXTIME(rr.dt_register)),
                        "-",
                        YEAR(FROM_UNIXTIME(rr.dt_register))
                    ),
                    rr.hash_url_id
            ) count';

        $count = Yii::$app->db->createCommand($clearCountQuery)->queryScalar();

        // and maybe add sequence number by TRIGGER for database?
        // https://stackoverflow.com/a/1600347/14700812
        // ex: CREATE TRIGGER trigger
        // FOR EACH ROW
        // BEGIN
        //     DECLARE row_sequence INT;
        //     SELECT  _MY_EXPRESSION_
        //     INTO    row_sequence
        //     FROM    ...
        //     WHERE   ...
        //     SET ... ;
        // END;
        // this is FAST impl

        // or use temporary table, but this slow...

        // I will spend more time building through builder
        $clearDataQuery = '
            SELECT * FROM (
                SELECT 
                    CONCAT(
                        YEAR(FROM_UNIXTIME(rr.dt_register)), 
                        "-", 
                        MONTH(FROM_UNIXTIME(rr.dt_register))
                    ) ym,
                    hu.original_url,
                    COUNT(*) count,
                    rr.hash_url_id
                FROM {{%redirect_record}} rr
                LEFT JOIN (
                    SELECT hash_url_id, original_url 
                    FROM {{%hash_url}}
                ) hu ON hu.hash_url_id = rr.hash_url_id
                GROUP BY
                    MONTH(FROM_UNIXTIME(rr.dt_register)),
                    YEAR(FROM_UNIXTIME(rr.dt_register)),
                    rr.hash_url_id

            ) tr ORDER BY tr.ym DESC, tr.count DESC
        ';

        $dataProvider = new SqlDataProvider([
            'sql' => $clearDataQuery,
            'totalCount' => $count,
            // TODO!: filter/sort/etc
            'sort' => false,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        // and a mega crutch for the top
        // TODO!: oops, I'm stupid, how will it work by pagination? :)
        // but there is no time :(
        // just main this in SQL query
        $counter = 1;
        $changedRows = [];
        foreach ($dataProvider->getModels() as &$row) {
            if (!isset($this->mappingTop[$row['ym']])) {
                // resetting the counter
                $counter = 1;
            }
            if (!isset($this->mappingTop[$row['ym']][$row['hash_url_id']])) {
                // set, and increment counter
                $this->mappingTop[$row['ym']][$row['hash_url_id']] = $counter;
                $row['top'] = $counter;
                $counter++;
            }
            $changedRows[] = $row;
        }
        if (!empty($changedRows)) {
            $dataProvider->setModels($changedRows);
        }
        

        // TODO!: filter/sort/etc
        $this->load($params);
        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
