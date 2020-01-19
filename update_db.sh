#!/bin/bash

if (( $(uname) == "Darwin")) ; then 
	mysql_loc=/Applications/xampp/xamppfiles/bin/mysql
else 
	mysql_loc=/opt/lampp/bin/mysql
fi

"$mysql_loc" --user='root' --password='' wordpress_base < wp_dump.sql
