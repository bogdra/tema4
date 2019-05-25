<?php

namespace Views;

class Filter {

    public $unique_values;

    public function __construct(array $unique_values)
    {
        $this->unique_values = $unique_values;
    }

    public function output() {

		require_once('Templates/Filter.tpl.php');

	}

}