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
     * @var null|string Name of the config file without extension.
     */
    private $key = null;


    /**
     * Config constructor.
     * @param string $key Key
     */
    public function __construct(string $key)
    {
        if(self::checkKey($key)) $this->key = $key;
        else throw new BadMethodCallException("The given key in ".__METHOD__." of ".__CLASS__." is not a valid filename.");
    }

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
     * @param string $value Value saved to this file
     */
    public function set(string $value)
    {

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


        $file = Config::$dir . "/$this->key.php";
        $hand = fopen($file, "w");
        fwrite($hand, "<?php\n");
        if(!putValue($value, $hand))
            throw new Exception("Configuration value could not be saved.");
        fclose($hand);
    }

    /**
     * Get the saved value to the given key if exist.
     * @return string Value to the given key
     */
    public function get()
    {
        $value = null;

        $file = Config::$dir . "/$this->key.php";
        if(is_file($file)) {
            include $file;
        }
        return $value;
    }

    /**
     * Remove the value to the given key if exist.
     * @return bool Delete success?
     */
    public function remove() : bool
    {
        $file = Config::$dir . "/$this->key.php";
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