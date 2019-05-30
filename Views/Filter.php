<?php

namespace Views;

defined("SECURE") or exit('You do not have permissions to access the page.');

class Filter {

    public $unique_values;
    public $filtered_input;

    public function __construct(array $unique_values, array $filtered_input)
    {
        $this->unique_values = $unique_values;
        $this->filtered_input = $filtered_input;
    }

    public function output() {

		require_once('Templates/Filter.tpl.php');

	}

}