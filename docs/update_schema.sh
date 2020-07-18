#!/bin/bash
mysqldump --set-gtid-purged=off --disable-keys -d consolo > schema.sql
