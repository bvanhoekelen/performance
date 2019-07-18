<?php

declare(strict_types=1);

namespace Performance\Lib\Holders;

use Performance\Lib\Handlers\ConfigHandler;

/**
 * Class InformationHolder
 * @package Performance\Lib\Holders
 */
class InformationHolder
{
    /**
     * @var ConfigHandler
     */
    protected $config;

    // Run information holder

    /**
     * @var
     */
    protected $currentUser;

    /**
     * @var
     */
    protected $currentProcessId;

    /**
     * InformationHolder constructor.
     * @param ConfigHandler $config
     */
    public function __construct(ConfigHandler $config)
    {
        $this->config = $config;

        // Set information
        $this->activateConfig();
    }

    protected function activateConfig(): void
    {
        if ($this->config->isRunInformation()) {
            $this->setRunInformation();
        }
    }

    protected function setRunInformation()
    {
        // Set unknown
        $this->currentUser = '?';
        $this->currentProcessId = '?';

        // Set current user
        $this->currentUser = get_current_user();

        // Set current process id
        $this->currentProcessId = getmypid();
    }

    /**
     * @return mixed
     */
    public function getCurrentUser(): string
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
}
