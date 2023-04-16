#!/bin/bash
base=/storage/local/ConSolo
cd ${base}/src/Importing/DAT/TOSEC && php update.php
cd ${base}/src/Importing/DAT/NoIntro && php update.php
cd ${base}/src/Importing/DAT/Redump && php update.php
#cd ${base}/src/Importing/API/TheGamesDB && php update.php
cd ${base}/src/Importing/Program/LaunchBox && php update.php
#cd ${base}/src/Importing/Program/MAME && php update.php
cd ${base}/src/Importing/Web && php gametdb.php
