<?php namespace Performance\Lib\Holders;

use Performance\Lib\Handlers\ConfigHandler;

class InformationHolder
{
    // Config
    private $config;

    // Run information holder
    private $currentUser;
    private $currentProcessId;

    public function __construct(ConfigHandler $config)
    {
        $this->config = $config;

        // Set information
        $this->activateConfig();
    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @return mixed
     */
    public function getCurrentProcessId()
    {
        return $this->currentProcessId;
    }

//
// Private
//

    private function activateConfig()
    {
        if($this->config->isRunInformation())
            $this->setRunInformation();
    }

    private function setRunInformation()
    {
        // Set unknown
        $this->currentUser = '?';
        $this->currentProcessId = '?';

        // Set current user
        try{
            $this->currentUser = get_current_user();
        }catch (\ErrorException $exception) {}

        // Set current user
        try{
            $this->currentProcessId = getmypid();
        }catch (\ErrorException $exception) {}
    }
}