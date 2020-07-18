<?php
$result = strtolower(`gm convert -list format`);
preg_match_all('/^\s*([^\s]+) +[psuPSU] +.*$/msuU', $result, $matches);
$cmd = implode(',', $matches[1]);
$cmd = 'gm identify -format "%h %w %m %f\n," family/*{'.implode(',',$matches[1]).'}';
echo $cmd;
//echo `eval $cmd`.PHP_EOL;

