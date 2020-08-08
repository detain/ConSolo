<?php
require_once __DIR__.'/../../bootstrap.php';

$results = $db->query("select id from files2 where parent is null;");
$foundParents = [];
foreach ($results as $result) {
	$foundParents[] = $result['id'];
}
echo 'Loaded '.count($foundParents).' Parents'.PHP_EOL;
$results = $db->query("select parent from files2 where parent is not null group by parent;");
echo 'Loaded '.count($results).' Parent IDs from Children'.PHP_EOL;
$parents = [];
foreach ($results as $idx => $result) {
	$parents[] = $result['parent'];
}
echo 'Found '.count($parents).' Missing Parents'.PHP_EOL;
$missing = array_diff($parents, $foundParents);
echo 'Found '.count($missing).' Missing Parents'.PHP_EOL;
echo "delete from files2 where parent in (".implode(',', $missing).")".PHP_EOL;
$db->query("delete from files2 where parent in (".implode(',', $missing).")");
echo 'Done cleaning'.PHP_EOL;
