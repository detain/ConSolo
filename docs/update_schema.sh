#!/bin/bash
mysqldump --set-gtid-purged=off --disable-keys -d consolo |sed s#" AUTO_INCREMENT=[0-9]*"#""#g > schema.sql
