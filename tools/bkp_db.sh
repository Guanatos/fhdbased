#!/bin/sh
/usr/bin/mysqldump -u fhdbased -p -d fhdbased > MySQL/mysqldump.`date +%m%d%y%H%M%S`.sql
