<?php

namespace Models;

use mysql_xdevapi\Exception;

defined("SECURE") or exit('You do not have permissions to access the page.');

class Products
{

    private $filtered_input;
    private $csv_array;


    public function __construct($filtered_input)
    {
        $this->filtered_input = $filtered_input;
        $this->csv_array = $this->construct_csv_array();
    }


    public function get_results()
    {
        if (!$this->filtered_input) {

            return $this->csv_array;

        } else {

            return $this->get_filtered_results();

        }

    }


    private function construct_csv_array(): array
    {
        $results = array();

        if (($csv_handler = fopen(\Helpers\Configs::DATA_FILE, "r")) == false) {
            throw new Exception('The source file can\'t be open');
        }
        $keys = array();
        while (($data = fgetcsv($csv_handler, 300, ",")) !== false) {
            if ($data[0] == null) {
                continue;
            }
            $data = array_map(function ($item) {
                return trim($item);
            }, $data);
            if (empty($keys)) {
                $keys = $data;
            } else {
                $results[] = array_combine($keys, $data);
            }
        }
        return $results;
    }


    private function get_filtered_results()
    {

        $filter_model = ($this->filtered_input['model'] != 'all') ? $this->filtered_input['model'] : false;

        $filter_color = ($this->filtered_input['color'] != 'all') ? $this->filtered_input['color'] : false;

        $filter_year = ($this->filtered_input['year'] != 'all') ? $this->filtered_input['year'] : false;

        $filter_price = ($this->filtered_input['price'] > 0) ? $this->filtered_input['price'] : false;

        foreach ($this->csv_array as $k => $result) {

            $condition =
                ($filter_model !== false && $filter_model != $result['model'])
                || ($filter_color !== false && $filter_color != $result['color'])
                || ($filter_year !== false && $filter_year != $result['year'])
                || ($filter_price !== false && $filter_price < $result['price']);

            if (!$condition) {

                $final_result[] = $result;

            }

        }

        return $final_result;

    }


    public function get_unique_characteristics_values()
    {
        $keys_array = [];
        foreach ($this->csv_array as $element) {
            foreach ($element as $key => $value) {
                $keys_array[$key][] = $value;
            }
        }
        array_pop($keys_array);
        foreach ($keys_array as $key => $value) {
            $keys_array[$key] = array_values(array_unique($value));
            array_unshift($keys_array[$key], 'all');
            $keys_array[$key] = array_flip($keys_array[$key]);
            $keys_array[$key] = array_map(function () {
                return '';
            }, $keys_array[$key]);
        }
        return $keys_array;
    }


    public function insert_selected_into_unique_array()
    {
        $array = $this->get_unique_characteristics_values();
        foreach ($this->filtered_input as $key => $value) {
            $array[$key][$value] = ' selected';
        }
        array_pop($array);
        return $array;
    }
}






