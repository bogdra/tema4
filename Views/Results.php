<?php

namespace Views;

defined("SECURE") or exit('You do not have permissions to access the page');

class Results {
	
	private $results;
	
	public function __construct($results) {
		
		$this->results = $results;
		
	}
	
	public function output() {
		
		require_once('Templates/Results.tpl.php');
		
	}
	
}