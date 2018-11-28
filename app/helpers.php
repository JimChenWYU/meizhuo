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
     * 从 mix-manifest 文件获取路径
     * @param $file
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    function mix($file)
    {
        static $manifest = null;

        // 从public目录下读取 mix-manifest.json 文件
        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('mix-manifest.json')), true);
        }

        if (isset($manifest[$file])) {
            return $manifest[$file];
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}