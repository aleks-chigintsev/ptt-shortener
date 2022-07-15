#!/bin/bash
absolute_filename=`readlink -e "$0"`
directory_self=`dirname "$absolute_filename"`
projectdir=$directory_self"/../../"

while [ -n "$1" ]
do
case "$1" in
-h)
    echo "Init script"
    echo "Params:"
    echo "  -dbu [user] MySQL/MariaDB Database username"
    echo "  -dbp [password] MySQL/MariaDB Database password"
    echo "  -env [environment] Values: Development|Production"
    exit ;;
-dbu) dbu="$2"
shift ;;
-dbp) dbp="$2"
shift ;;
-env) env="$2"
shift ;; 
*) echo "$1 is not an option";;
esac
shift
done

if [[ -z $dbu || -z $dbp || -z $env ]]; then
    echo "Please use -h param for more details" 
    exit
fi
if [[ $env != "Development" && $env != "Production" ]]; then
    echo "Environment values: Development|Production" 
    exit
fi

mysql -u $dbu -p$dbp -e '\q'
connection_status=$?
if [[ $connection_status != "0" ]]; then
    echo "Wrong username/password for DB connection"
    exit
fi

mysql -u $dbu -p$dbp -e "
    CREATE DATABASE IF NOT EXISTS ptt_shortener DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; 
    CREATE DATABASE IF NOT EXISTS ptt_shortener_test DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; 
"

cd $projectdir
composer install

php init --env=$env --overwrite=All

# write config file
if [[ $env == "Development" ]]; then
    sed -i -e 's/$DB_USERNAME/'"$dbu"'/g' "${projectdir}common/config/main-local.php"
    sed -i -e 's/$DB_PASSWORD/'"$dbp"'/g' "${projectdir}common/config/main-local.php"
elif [[ $env == "Production" ]]; then
    sed -i -e 's/$DB_USERNAME/'"$dbu"'/g' "${projectdir}common/config/common/main.php"
    sed -i -e 's/$DB_PASSWORD/'"$dbp"'/g' "${projectdir}common/config/common/main.php"
fi

# migrations to common DB's
php yii migrate --interactive=0
# migrations to test DB's
php yii_test migrate --interactive=0