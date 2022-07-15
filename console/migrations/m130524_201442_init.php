<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-
            // difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // The field original_url as text since most browsers support url 
        // lengths of more than 2000 characters. 
        // For faster indexing, we use md5 hash and search for it.
        $this->createTable('{{%hash_url}}', [
            'hash_url_id' => $this->primaryKey(),
            'original_url' => $this->text()->notNull(),
            // MySQL/MariaDB search is case insensitive by default
            'hash' => 'VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL',
            'md5_hash' => "BINARY(16) NOT NULL",
        ], $tableOptions);
        $this->createIndex('INDEX__hash', '{{%hash_url}}', ['hash'], true);
        $this->createIndex('INDEX__md5_hash', '{{%hash_url}}', ['md5_hash']);

        $this->createTable('{{%redirect_record}}', [
            'redirect_record_id' => $this->bigPrimaryKey(),
            'hash_url_id' => $this->integer()->notNull(),
            'dt_register' => $this->integer()->notNull(),
            // for future analytics
            'ua' => $this->text()->notNull(),
        ]);
        $this->createIndex('INDEX__dt_register', '{{%redirect_record}}', ['dt_register']);

    }

    public function down()
    {
        $this->dropTable('{{%hash_url}}');
        $this->dropTable('{{%redirect_record}}');
    }
}
