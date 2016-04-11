#!/bin/sh

WHOAMI=`python -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`
WHEREAMI=`dirname $WHOAMI`
ROOT=`dirname $WHEREAMI`

PROJECT=$1

if [ ! -d ${PROJECT} ]
then
    echo "PROJECT DOES NOT EXIST!"
    exit 1
fi

if [ ! -e ${PROJECT}/www/include/lib_uuid.php ]
then
    echo "lib_logstash depends on lib_uuid, please install that first"
    exit 1
fi

if [ ! -e ${PROJECT}/www/include/lib_logstash.php ]
then
    echo "lib_logstash depends on lib_redis, please install that first"
    echo "https://github.com/whosonfirst/flamework-logstash"
    exit 1
fi

cp ${ROOT}/www/include/lib_offline_tasks.php ${PROJECT}/www/include/

if [ ! -e ${PROJECT}/www/include/lib_offline_tasks_do.php ]
then
    cp ${ROOT}/www/include/lib_offline_tasks_do.php ${PROJECT}/www/include/
fi

# echo "" >> ${PROJECT}/www/include/config.php
# cat ${ROOT}/www/include/config.php.offline-tasks 

exit 0
