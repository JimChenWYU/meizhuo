<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/4/3
 * Time: 11:28
 */

if (! function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param $file
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    function mix($file)
    {
        static $manifest = null;

        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('mix-manifest.json')), true);
        }

        if (isset($manifest[$file])) {
            return $manifest[$file];
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}