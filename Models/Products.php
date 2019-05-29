<?php

namespace Models;

class Products
{

    private $filtered_input;
    private $csv_array;


    public function __construct($filtered_input)
    {
        $this->filtered_input = $filtered_input;
        if ($this->filtered_input['year'] == 0) {
            $this->filtered_input['year'] = 'all';
        }
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
        $this->results = array();

        $csv_string = file_get_contents('data.csv');

        $csv_arr = explode("\r\n", $csv_string);

        $csv_arr = array_diff($csv_arr, array(''));

        $csv_arr = array_values($csv_arr);

        $header_arr = explode(',', $csv_arr[0]);

        unset($csv_arr[0]);

        foreach ($csv_arr as $row) {

            $row_arr = explode(',', $row);

            $row_new = array();

            foreach ($row_arr as $k => $v) {

                $k_new = trim($header_arr[$k]);
                $v_new = trim($v);

                $row_new[$k_new] = $v_new;

            }

            $this->results[] = $row_new;

        }
        return $this->results;
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






