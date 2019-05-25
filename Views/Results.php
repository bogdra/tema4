<?php

namespace Views;

class Results {
	
	private $results;
	
	public function __construct($results) {
		
		$this->results = $results;
		
	}
	
	public function output() {
		
		require_once('Templates/Results.tpl.php');
		
	}
	
}