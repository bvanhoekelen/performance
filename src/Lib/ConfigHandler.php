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
        if( isset($this->configItems[$item]) )
            $this->configItems[$item] = $value;
        else
            dd('Config item: "' . $item . '" does not exist! You can only change:',
                $this->getAllItemNames());
    }


    public function getAllItemNames()
    {
        return array_keys($this->configItems);
    }

}