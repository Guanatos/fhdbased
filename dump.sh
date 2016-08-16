#!/bin/sh -x
#	echo "Usage: ./dump.sh <data?? y>"
#argument_error()
#{
#	echo "argument error"
#	echo "Usage: ./dump.sh <data?? y>"
#	exit 1
#}
DATE=`date +%m%d%y%H%M%S`
if [ $# -gt 0 ]; then
	mysqldump -u root -p fhdbased > fhdbased.data.$DATE.sql
else
	mysqldump -u root -p --no-data fhdbased > fhdbased.nodata.$DATE.sql
fi
