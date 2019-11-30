#!/bin/bash

if (( $(uname) == "Darwin")) ; then 
	mysql_loc=/Applications/xampp/xamppfiles/bin/mysqldump
else 
	mysql_loc=/opt/lampp/bin/mysqldump
fi

# For mac (this is Xampps mysql location)
"$mysql_loc" --user='root' --password='' wordpress_base > wp_dump_new.sql
