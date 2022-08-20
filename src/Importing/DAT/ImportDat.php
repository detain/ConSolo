<?php
namespace Detain\ConSolo\Importing\DAT;

class ImportDat
{
	public $deleteOld = true;
    public $replacements = [];
    public $skipDb = false;
    public $source = [];
    public $multiRun = false;
    public $type;

	public function __construct() {
	}

    public function writeSource() {
        file_put_contents(__DIR__.'/../../../../emurelation/sources/'.strtolower(str_replace('-', '', $this->type)).'.json', json_encode($this->source, getJsonOpts()));
    }

    public function setMultiRun(bool $multiRun) {
        $this->multiRun = $multiRun;
        return $this;
    }

    public function setSkipDb(bool $skipDb) {
        $this->skipDb = $skipDb;
        return $this;
    }

    public function setReplacements(array $replacements) {
        $this->replacements = $replacements;
        return $this;
    }

    public function FlattenAttr(&$parent) {
        if (isset($parent['attr'])) {
            if (count($parent['attr']) == 2 && isset($parent['attr']['name']) && isset($parent['attr']['value'])) {
                $parent[$parent['attr']['name']] = $parent['attr']['value'];
                unset($parent['attr']);
            } else {
                foreach ($parent['attr'] as $attrKey => $attrValue) {
                    $parent[$attrKey] = $attrValue;
                }
                unset($parent['attr']);
            }
        }
    }

    public function FlattenValues(&$parent) {
        foreach ($parent as $key => $value) {
            if (is_array($value) && count($value) == 1 && isset($value['value'])) {
                $parent[$key] = $value['value'];
            }
        }
    }

    public function RunArray(&$data) {
        if (is_array($data)) {
            if (count($data) > 0) {
                if (isset($data[0])) {
                    foreach ($data as $dataIdx => $dataValue) {
                        $this->RunArray($dataValue);
                        $data[$dataIdx] = $dataValue;
                    }
                } else {
                    $this->FlattenAttr($data);
                    $this->FlattenValues($data);
                    foreach ($data as $dataIdx => $dataValue) {
                        $this->RunArray($dataValue);
                        $data[$dataIdx] = $dataValue;
                    }
                }
            }
        }
    }

	public function go($type, $glob, $storageDir) {
		/**
		* @var \Workerman\MySQL\Connection
		*/
		global $db;
		global $config;
        $this->type = $type;
		echo 'Importing '.$type.' DATs..'.PHP_EOL;
		if ($this->skipDb === false && $this->deleteOld == true) {
			$db->query("delete from dat_files where type='{$type}'");
		}
        if (count($this->source) == 0) {
            $this->source = [
                'platforms' => []
            ];
        }
		foreach (glob($glob) as $xmlFile) {
			$list = basename($xmlFile, '.dat');
			echo "[{$list}] Reading..";
			$string = file_get_contents($xmlFile);
			echo "XML To Array..";
			$array = xml2array($string, 1, 'attribute');
			unset($string);
			echo "Simplifying..";
			$this->RunArray($array);
			echo "Writing JSON..";
			@mkdir($storageDir.'/json/dat/'.$type);
			file_put_contents($storageDir.'/json/dat/'.$type.'/'.$list.'.json', json_encode($array, getJsonOpts()));
            $name = $fullName = $array['datafile']['header']['name'];
            foreach ($this->replacements as $replacement) {
                $name = preg_replace($replacement[0], $replacement[1], $name);
            }
            $this->source['platforms'][$fullName] = [
                'id' => $fullName,
                'name' => $fullName,
                'altNames' => []
            ];
            if ($name != $fullname)
                $this->source['platforms'][$fullName]['altNames'][] = $name;
            $pos = strpos($name, ' - ');
            if ($pos !== false) {
                $company = substr($name, 0, $pos);
                $platformName = substr($name, $pos + 3);
                $this->source['platforms'][$fullName]['altNames'][] = $platformName;
                $this->source['platforms'][$fullName]['altNames'][] = $company.' '.$platformName;
                $this->source['platforms'][$fullName]['company'] = $company;
            }
			echo "DB Entries..";
			if (isset($array['datafile']['game'])) {
				$cols = $array['datafile']['header'];
				$cols['type'] = $type;
				if (isset($cols['romcenter'])) {
					$cols['romcenter'] = $cols['romcenter']['plugin'];
				}

				if (isset($cols['clrmamepro'])) {
					foreach (['forcepackaging', 'forcenodump', 'forcemerging'] as $section) {
						if (isset($cols['clrmamepro'][$section])) {
							$cols['clrmamepro_'.$section] = $cols['clrmamepro'][$section];
						}
					}
					unset($cols['clrmamepro']);
				}
				foreach (['description','version','author','homepage','url'] as $section) {
					if (isset($cols[$section]) && is_array($cols[$section]) && count($cols[$section]) == 0) {
						unset($cols[$section]);
					}
				}
				//echo 'dat_files:'.json_encode($cols, getJsonOpts()).PHP_EOL;
                if ($this->skipDb === false) {
                    try {
                        $fileId = $db->insert('dat_files')
                            ->cols($cols)
                            ->lowPriority($config['db']['low_priority'])
                            ->query();
                    } catch (\PDOException $e) {
                        die('Caught PDO Exception!'.PHP_EOL
                        .'Values:'.var_export($cols, true).PHP_EOL
                        .'Message:'.$e->getMessage().PHP_EOL
                        .'Code:'.$e->getCode().PHP_EOL
                        .'File:'.$e->getFile().PHP_EOL
                        .'Line:'.$e->getLine().PHP_EOL);
                    }
                }
				$gameSections = ['rom','disk','release','sample','biosset'];
				if (isset($array['datafile']['game']['name']))
					$array['datafile']['game'] = [$array['datafile']['game']];
				echo count($array['datafile']['game'])." games..";
				foreach ($array['datafile']['game'] as $gameIdx => $gameData) {
					$cols = $gameData;
					$cols['file'] = $fileId;
					foreach ($gameSections as $section) {
						unset($cols[$section]);
						if (isset($gameData[$section]) && isset($gameData[$section]['name']))
							$gameData[$section] = [$gameData[$section]];
					}
					if (isset($cols['manufacturer']) && is_array($cols['manufacturer']) && count($cols['manufacturer']) == 0) {
						unset($cols['manufacturer']);
					}
					//echo 'dat_games:'.json_encode($cols, getJsonOpts()).PHP_EOL;
                    if ($this->skipDb === false) {
					    try {
						    $gameId = $db->insert('dat_games')
                                ->cols($cols)
                                ->lowPriority($config['db']['low_priority'])
                                ->query();
					    } catch (\PDOException $e) {
						    die('Caught PDO Exception!'.PHP_EOL
						    .'Values:'.var_export($cols, true).PHP_EOL
						    .'Message:'.$e->getMessage().PHP_EOL
						    .'Code:'.$e->getCode().PHP_EOL
						    .'File:'.$e->getFile().PHP_EOL
						    .'Line:'.$e->getLine().PHP_EOL);
					    }
                    }
					foreach ($gameSections as $section) {
						if (isset($gameData[$section])) {
							foreach ($gameData[$section] as $sectionIdx => $sectionData) {
								$cols = $sectionData;
								if ($section == 'rom') {
									foreach (['crc','md5','sha1'] as $field) {
										if (isset($cols[$field]) && !is_null($cols[$field])) {
											$cols[$field] = strtolower($cols[$field]);
										}
									}
								}
								$cols['game'] = $gameId;
								//echo 'dat_'.$section.'s:'.json_encode($cols, getJsonOpts()).PHP_EOL;
                                if ($this->skipDb === false) {
								    try {
									    $db->insert('dat_'.$section.'s')
                                            ->cols($cols)
                                            ->lowPriority($config['db']['low_priority'])
                                            ->query();
								    } catch (\PDOException $e) {
									    die('Caught PDO Exception!'.PHP_EOL
									    .'Values:'.var_export($cols, true).PHP_EOL
									    .'Message:'.$e->getMessage().PHP_EOL
									    .'Code:'.$e->getCode().PHP_EOL
									    .'File:'.$e->getFile().PHP_EOL
									    .'Line:'.$e->getLine().PHP_EOL);
								    }
                                }
							}
						}
					}
				}
				echo "done\n";
			} else {
				echo "no games, skipping\n";
			}
		}
        if (!$this->multiRun)
            $this->writeSource();
        return $this;
	}
}
