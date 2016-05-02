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
     * Function for checking the key is a valid one.
     * @param string $key Key to be checked
     * @return bool Is the key valid?
     */
    static function checkKey(string $key) : bool
    {
        if(mb_ereg_match("^[A-Za-z0-9_\.-]$", $key)) return true;
        return false;
    }

    /**
     * Add/Set a configuration value.
     * @param string $key Filename
     * @param string $value Value saved to this file
     */
    static function set(string $key, string $value)
    {
        if(!self::checkKey($key)) throw new InvalidArgumentException("Key may be a valid filename.");

        function putValue($data, $handle) : bool {

            // no need to save if value is null (default return value of get)
            if($data === null) {
                return true;
            }

            // Try writing data to file.
            try {
                fwrite($handle, '$value = ' . var_export($data, true) . ";\n");
                return true;
            } catch (Throwable $e) {
                return false;
            }
        }


        $file = Config::$dir . "/$key.php";
        $hand = fopen($file, "w");
        fwrite($hand, "<?php\n");
        if(!putValue($value, $hand))
            throw new Exception("Configuration value could not be saved.");
        fclose($hand);
    }

    /**
     * Get the saved value to the given key if exist.
     * @param string $key Filename
     * @return string Value to the given key
     */
    static function get(string $key)
    {
        if(!self::checkKey($key)) throw new InvalidArgumentException("Key may be a valid filename.");

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
        if(!self::checkKey($key)) throw new InvalidArgumentException("Key may be a valid filename.");

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