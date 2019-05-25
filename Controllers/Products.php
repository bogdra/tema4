<?php

namespace Controllers;

class Products {
	
	private $input;
	private $filtered_input;
	
	public function __construct() {
	
		$this->input = !empty($_REQUEST) ? $_REQUEST : false;
		
		if (!$this->input) {
			
			$this->filtered_input = false;
			
		} else {
			
			$this->sanitize_input();
			
		}
		
	}
	
	public function display() {

		//var_dump($this->input);
		//var_dump($this->filtered_input);

		$products_model = new \Models\Products($this->filtered_input);
		$results = $products_model->get_results();
		$unique_char_values = $products_model->get_unique_characteristics_values();

		$filter_view = new \Views\Filter($unique_char_values);
		$filter_view->output();
		
		$results_view = new \Views\Results($results);
		$results_view->output();

	}

	private function sanitize_input() {
	
		$string_fields = array(
			'model',
			'color',
		);
		
		$numeric_fields = array(
			'year',
			'price',
		);
		
		foreach ($this->input as $k => $v) {
		
			if (in_array($k, $string_fields)) {
			
				$this->filtered_input[$k] = trim(strip_tags($v));
				
			} else if (in_array($k, $numeric_fields)) {
			
				$this->filtered_input[$k] = (float)$v;
				
			}
			
		}
		
	}
	
}



