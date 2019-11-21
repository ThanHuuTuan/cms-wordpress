#!/bin/bash

# For Mac (uses Xampp mysql location)
/Applications/xampp/xamppfiles/bin/mysql --user='root' --password='' wordpress_base < wp_dump.sql
