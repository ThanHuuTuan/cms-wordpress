#!/bin/bash

# For mac (this is Xampps mysql location)
/Applications/xampp/xamppfiles/bin/mysqldump --user='root' --password='' wordpress_base > wp_dump_new.sql
