#!/bin/bash

# If on Mac
/Applications/xampp/xamppfiles/bin/mysql --user='root' --password='' wordpress_base < wp_dump.sql
