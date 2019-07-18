<?php

declare(strict_types=1);

namespace tests\src\Lib\Handlers;

use InvalidArgumentException;
use Performance\Lib\Handlers\ConfigException;
use Performance\Lib\Handlers\ConfigHandler;
use PHPUnit_Framework_TestCase;

/**
 * Class ConfigHandlerTest
 * @package tests\src\Lib\Handlers
 *
 * @covers \Performance\Lib\Handlers\ConfigHandler::export
 * @covers \Performance\Lib\Handlers\ConfigHandler::setClearScreen
 * @covers \Performance\Lib\Handlers\ConfigHandler::setConsoleLive
 * @covers \Performance\Lib\Handlers\ConfigHandler::setEnableTool
 * @covers \Performance\Lib\Handlers\ConfigHandler::setPointLabelLTrim
 * @covers \Performance\Lib\Handlers\ConfigHandler::setPointLabelRTrim
 * @covers \Performance\Lib\Handlers\ConfigHandler::setPointLabelNice
 * @covers \Performance\Lib\Handlers\ConfigHandler::setQueryLog
 * @covers \Performance\Lib\Handlers\ConfigHandler::setRunInformation
 */
class ConfigHandlerTest extends PHPUnit_Framework_TestCase
{
    private const QUERY_LOG_STATE = 'queryLogState';
    private const CONSOLE_LIVE = 'consoleLive';
    private const ENABLE_TOOL = 'enableTool';
    private const QUERY_LOG = 'queryLog';
    private const QUERY_LOG_VIEW = 'queryLogView';
    private const POINT_LABEL_L_TRIM = 'pointLabelLTrim';
    private const POINT_LABEL_R_TRIM = 'pointLabelRTrim';
    private const POINT_LABEL_NICE = 'pointLabelNice';
    private const RUN_INFORMATION = 'runInformation';
    private const CLEAR_SCREEN = 'clearScreen';
    private const PRESENTER = 'presenter';

    /**
     * @var ConfigHandler
     */
    protected $instance;

    protected function setUp()
    {
        $this->instance = new ConfigHandler();
    }

    /**
     * @test
     */
    public function initConfigVars()
    {
        //Arrange
        $expected = [
            self::QUERY_LOG_STATE => null,
            self::CONSOLE_LIVE => false,
            self::ENABLE_TOOL => true,
            self::QUERY_LOG => false,
            self::QUERY_LOG_VIEW => null,
            self::POINT_LABEL_L_TRIM => false,
            self::POINT_LABEL_R_TRIM => false,
            self::POINT_LABEL_NICE => false,
            self::RUN_INFORMATION => false,
            self::CLEAR_SCREEN => true,
            self::PRESENTER => 1,
        ];

        //Act
        $export = $this->instance->export();

        //Assert
        $this->assertEquals($expected, $export);
    }

    /**
     * @test
     * @throws ConfigException
     */
    public function setupConfigVar()
    {
        //Arrange
        $expected = [
            self::QUERY_LOG_STATE => null,
            self::CONSOLE_LIVE => true,
            self::ENABLE_TOOL => true,
            self::QUERY_LOG => true,
            self::QUERY_LOG_VIEW => 'resume',
            self::POINT_LABEL_L_TRIM => true,
            self::POINT_LABEL_R_TRIM => true,
            self::POINT_LABEL_NICE => true,
            self::RUN_INFORMATION => true,
            self::CLEAR_SCREEN => false,
            self::PRESENTER => 1,
        ];
        $this->instance->setClearScreen(false);
        $this->instance->setConsoleLive(true);
        $this->instance->setEnableTool(true);
        $this->instance->setPointLabelLTrim(true);
        $this->instance->setPointLabelRTrim(true);
        $this->instance->setPointLabelNice(true);
        $this->instance->setQueryLog(true);
        $this->instance->setRunInformation(true);

        //Act
        $export = $this->instance->export();

        //Assert
        $this->assertEquals($expected, $export);
    }

    /**
     * @test
     */
    public function setupConfigVarWithInvalidQueryLogOptions()
    {
        //Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Query log view foo does not exists, use: \'resume\' or \'full\'');

        $this->instance->setQueryLog(true, 'foo');

        //Act

        //Assert
    }

    /**
     * @test
     */
    public function setupConfigVarWithValidQueryLogOptions()
    {
        //Arrange
        $expected = [
            self::QUERY_LOG_STATE => null,
            self::CONSOLE_LIVE => false,
            self::ENABLE_TOOL => true,
            self::QUERY_LOG => true,
            self::QUERY_LOG_VIEW => 'full',
            self::POINT_LABEL_L_TRIM => false,
            self::POINT_LABEL_R_TRIM => false,
            self::POINT_LABEL_NICE => false,
            self::RUN_INFORMATION => false,
            self::CLEAR_SCREEN => true,
            self::PRESENTER => 1,
        ];
        $this->instance->setQueryLog(true, 'full');

        //Act
        $export = $this->instance->export();

        //Assert
        $this->assertEquals($expected, $export);
    }

    /**
     * @throws ConfigException
     */
    public function testEnableToolWithInvalidIntValue()
    {
        //Arrange
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage('Config::DISABLE_TOOL value 123 not supported!');

        $this->instance->setEnableTool(123);

        //Act

        //Assert
    }

    /**
     * @throws ConfigException
     */
    public function testEnableToolWithInvalidStringValue()
    {
        //Arrange
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage('Config::DISABLE_TOOL value string foo:bar not supported! Check if ENV and value exists.');

        $this->instance->setEnableTool('foo:bar');
        //Act

        //Assert
    }

    public function testPresenterWithInvalidIntValue()
    {
        //Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Presenter foo does not exists. Use: console or web.');

        $this->instance->setPresenter('foo');

        //Act

        //Assert
    }

    public function testPresenterWithValidIntValue()
    {
        //Arrange
        $expected = [
            self::QUERY_LOG_STATE => null,
            self::CONSOLE_LIVE => false,
            self::ENABLE_TOOL => true,
            self::QUERY_LOG => false,
            self::QUERY_LOG_VIEW => null,
            self::POINT_LABEL_L_TRIM => false,
            self::POINT_LABEL_R_TRIM => false,
            self::POINT_LABEL_NICE => false,
            self::RUN_INFORMATION => false,
            self::CLEAR_SCREEN => true,
            self::PRESENTER => 2,
        ];

        $this->instance->setPresenter('web');

        //Act
        $export = $this->instance->export();

        //Assert
        $this->assertEquals($expected, $export);
    }
}