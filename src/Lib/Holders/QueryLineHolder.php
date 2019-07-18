<?php

declare(strict_types=1);

namespace Performance\Lib\Holders;

/**
 * Class QueryLineHolder
 * @package Performance\Lib\Holders
 */
class QueryLineHolder
{
    /**
     * @var
     */
    protected $line;

    /**
     * @var
     */
    protected $time;

    /**
     * @return string
     */
    public function getLine():string
    {
        return $this->line;
    }

    /**
     * @param mixed $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return string
     */
    public function getTime():string
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = number_format((float)$time, 2, '.', '');
    }
}
