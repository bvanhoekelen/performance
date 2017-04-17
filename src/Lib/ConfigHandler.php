<?php namespace Performance\Lib;

use Performance\Config;

class ConfigHandler
{

    private $configItems = [];

    public function __construct()
    {
        $this->setDefault();
    }

    private function setDefault()
    {
        // Set default configs
        $this->configItems = [
            Config::CONSOLE_LIVE => false,
            Config::POINT_LABEL_LTRIM => false,
            Config::POINT_LABEL_RTRIM => false,
            Config::DISABLE_TOOL => false,
        ];
    }

    public function reset()
    {
        $this->setDefault();
    }

    /*
     * Get config item
     *
     * @param string    $item
     * @return mixed
     */
    public function get($item, $default = null)
    {
        if( isset($this->configItems[$item]) )
            return $this->configItems[$item];
        elseif($default)
            return $default;
        else
            dd('Config item: "' . $item . '" does not exist! Use:',
                $this->getAllItemNames());
    }

    /*
     * Set config item
     *
     * @param string    $item
     * @param mixed     $value
     */
    public function set($item, $value)
    {
        if($item == Config::DISABLE_TOOL)
            $this->setItemDisableTool($value);
        elseif( isset($this->configItems[$item]) )
            $this->configItems[$item] = $value;
        else
            dd('Config item: "' . $item . '" does not exist! You can only change:',
                $this->getAllItemNames());
    }


    public function getAllItemNames()
    {
        return array_keys($this->configItems);
    }

    private function setItemDisableTool($value)
    {
        if(is_bool($value))
            $this->configItems[Config::DISABLE_TOOL] = $value;
        elseif(is_string($value))
        {
            $split = explode(':', $value);

            // Determinable stat on ENV
            if(isset($split[1]) and $split[0] == 'ENV' and function_exists('env'))
                $this->configItems[Config::DISABLE_TOOL] =  (env($split[1])) ? false : true; // true is false !
            else
                dd('Config::DISABLE_TOOL value string not supported! Check if ENV and value exists', $value, $split);
        }
        else
            dd('Config::DISABLE_TOOL value not supported!', $value);

    }

}