<?php

namespace Models;

class Products
{

    private $filtered_input;
    private $results = array();
    private $parsed_csv_arr;

    public function __construct($filtered_input)
    {

        $this->filtered_input = $filtered_input;
        $this->parsed_csv_arr = $this->construct_csv_array();

    }

    public function get_results()
    {

        if (!$this->filtered_input) {

           return $this->parsed_csv_arr;

        } else {

          return  $this->get_filtered_results();

        }

    }

    private function construct_csv_array():array
    {

        $csv_string = file_get_contents('data.csv');

        $csv_arr = explode(PHP_EOL, $csv_string);

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

            $final_arr[] = $row_new;

        }
        return $final_arr;
    }

    private function get_filtered_results()
    {

        $filter_model = ($this->filtered_input['model'] != 'all') ? $this->filtered_input['model'] : false;

        $filter_color = ($this->filtered_input['color'] != 'all') ? $this->filtered_input['color'] : false;

        $filter_year = ($this->filtered_input['year'] != 'all') ? $this->filtered_input['year'] : false;

        $filter_price = ($this->filtered_input['price'] > 0) ? $this->filtered_input['price'] : false;

        foreach ($this->parsed_csv_arr as $k => $result) {

            $condition =
                ($filter_model !== false && $filter_model != $result['model'])
                || ($filter_color !== false && $filter_color != $result['color'])
                || ($filter_year !== false && $filter_year != $result['year'])
                || ($filter_price !== false && $filter_price < $result['price']);

            if (!$condition) {

                $final_result[] = $this->parsed_csv_arr;

            }

        }
        return $final_result;

    }

}






