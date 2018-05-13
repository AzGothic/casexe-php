<?php

namespace app\base\helper;

/**
 * HelperDir class definition
 */
class HelperDir
{
    const TYPE_DIR  = 'DIR';
    const TYPE_FILE = 'FILE';
    const TYPE_ELSE = 'ELSE';

    public static function ls($dir)
    {
        $list = [];

        if (!is_dir($dir))
            return $list;

        $list = [
                static::TYPE_DIR  => [],
                static::TYPE_FILE => [],
                static::TYPE_ELSE => [],
            ];

        $dr = @opendir($dir);
        while (false !== ($name = @readdir($dr))) {
            if ($name != '.' and $name != '..') {
                $path = $dir . DIRECTORY_SEPARATOR . $name;
                $type = is_dir($path) ? static::TYPE_DIR : (is_file($path) ? static::TYPE_FILE : static::TYPE_ELSE);
                $list[$type][$name] = $path . ($type == static::TYPE_DIR ? DIRECTORY_SEPARATOR : '');
            }
        }
        @closedir($dr);

        if (empty($list[static::TYPE_DIR]))
            $list[static::TYPE_DIR] = [];
        if (empty($list[static::TYPE_FILE]))
            $list[static::TYPE_FILE] = [];

        return $list;
    }
}