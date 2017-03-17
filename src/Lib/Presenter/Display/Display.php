<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\Presenter\Formatter;

class Display
{
    protected $pointStage;
    protected $masterPoint;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = new Formatter();
    }

}