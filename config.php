<?php
/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 30.04.2016
 * Time: 17:28
 */

/**
 * Class Config Simple File Configuration System.
 */
class Config
{

    /**
     * @var string Where to put the config files?
     */
    static $dir = "configs";

    /**
     * Add/Set a configuration value.
     * @param string $key Filename
     * @param string $value Value saved to this file
     */
    static function set(string $key, string $value)
    {
        function checkKey(string $k) : bool {
            if(mb_ereg_match("^([A-z0-9\.-_]*)$", $k)) return true;
            return false;
        }

        function prepareValue(string $d) : string {
            return '"'.mb_ereg_replace("/(((([\\]{2})+([\\]{1}))?)\")/", "$2\\\"", $d).'"';
        }
        function prepareValue(int $d) : string {
            return "$d";
        }
        function prepareValue(float $d) : string {
            return "$d";
        }
        function prepareValue(bool $d) : string {
            return ($d ? 'true' : 'false');
        }

        if(!checkKey($key)) throw new InvalidArgumentException("Key may be a valid filename.");

        $file = Config::$dir . "/$key.php";
        $hand = fopen($file, "w");
        fwrite($hand, "<?php\n");
        if($value == null) {
            fwrite($hand, '$value = null;');
        } else {
            fwrite($hand, '$value = '.prepareValue($value).';');
        }
        fclose($hand);
    }

    /**
     * Get the saved value to the given key if exist.
     * @param string $key Filename
     * @return string Value to the given key
     */
    static function get(string $key)
    {
        function checkKey(string $k) : bool {
            if(mb_ereg_match("^([A-z0-9\.-_\s]*)$", $k)) return true;
            return false;
        }

        if(!checkKey($key)) throw new InvalidArgumentException("Key may be a valid filename.");
        $value = null;

        $file = Config::$dir . "/$key.php";
        if(is_file($file)) {
            include $file;
        }
        return $value;
    }

    /**
     * Remove the value to the given key if exist.
     * @param string $key Filename
     * @return bool Delete success?
     */
    static function remove(string $key) : bool
    {
        function checkKey(string $k) : bool {
            if(mb_ereg_match("^([A-z0-9\.-_\s]*)$", $k)) return true;
            return false;
        }

        if(!checkKey($key)) throw new InvalidArgumentException("Key may be a valid filename.");

        $file = Config::$dir . "/$key.php";
        if(is_file($file)) {
            try {
                unlink($file);
                return true;
            } catch (Throwable $e) {
                return false;
            }
        }
        return true;
    }

}