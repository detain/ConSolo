<?php

namespace Detain\ConSolo\Models;

class Base {
	
	/**
	* @var \Workerman\MySQL\Connection
	*/
	protected $db;
	/**
	* @var \Twig\Environment
	*/
	protected $twig;
	protected $config;
	protected $curl_config;
	protected $hostId;
	
	/**
	* @param \Workerman\MySQL\Connection $db
	* @param \Twig\Environment $twig
	*/
	public function __construct(\Workerman\MySQL\Connection $db, \Twig\Environment $twig) {
		$this->db = $db;
		$this->twig = $twig;
		global $config, $curl_config, $hostId;
		$this->config = $config;
		$this->curl_config = $curl_config;
		$this->hostId = $hostId;
	}
		

}  
