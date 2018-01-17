<?php
namespace Framework\Core;

class Loader
{

    private static $registers;

    public static function add($prefix, $base_dir)
    {
        self::$registers[$prefix] = $base_dir;
    }

    public static function get()
    {
        return self::$registers;
    }

    public static function register()
    {

        spl_autoload_register(function($class) {

            $cont = 0;
            foreach (self::$registers as $prefix => $base_dir) {

                $cont++;

                $base_dir = $base_dir;

                $len = strlen($prefix);

                if (strncmp($prefix, $class, $len) !== 0) {

                    continue;
                }

                $relative_class = substr($class, $len);

                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
}
