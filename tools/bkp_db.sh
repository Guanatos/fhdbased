#!/bin/sh
echo "Structure"
/usr/bin/mysqldump -u fhdbased -p --no-data -d fhdbased > MySQL/mysqldump.`date +%m%d%y%H%M%S`.sql
echo "Data"
/usr/bin/mysqldump -u fhdbased -p --no-create-info -d fhdbased > MySQL/mysqldump.`date +%m%d%y%H%M%S`.sql
