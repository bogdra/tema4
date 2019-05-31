<?php

namespace Helpers;

class Configs
{
    const DATA_FILE = 'data.csv';
    public static function autoload()
    {

        spl_autoload_register(function ($class_name) {

            $class_name_arr = explode('\\', $class_name);

            $file = end($class_name_arr) . '.php';
            array_pop($class_name_arr);
            $path = (count($class_name_arr) > 1)
                ? implode(DIRECTORY_SEPARATOR, $class_name_arr) . DIRECTORY_SEPARATOR . $file
                : $class_name_arr[0] . DIRECTORY_SEPARATOR . $file;
            require_once($path);

        });

    }

}
