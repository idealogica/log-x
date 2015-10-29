<?php
use Idealogica\LogX;
use Psr\Log\LogLevel;
use org\bovigo\vfs\vfsStream;

class LogXTest extends PHPUnit_Framework_TestCase
{
    public function testPsrMethods()
    {
        vfsStream::setup();
        (new LogX('vfs://root/test.log'))->
            alert('alert')->
            critical('critical')->
            debug('debug')->
            emergency('emergency')->
            error('error')->
            info('info')->
            notice('notice')->
            warning('warning')->
            log(LogLevel::ALERT, 'log');
        $logContents = file_get_contents('vfs://root/test.log');
        self::assertContains('alert', $logContents);
        self::assertContains('critical', $logContents);
        self::assertContains('debug', $logContents);
        self::assertContains('emergency', $logContents);
        self::assertContains('error', $logContents);
        self::assertContains('info', $logContents);
        self::assertContains('notice', $logContents);
        self::assertContains('warning', $logContents);
        self::assertContains('log', $logContents);
    }

    public function testTimeOutput()
    {
        vfsStream::setup();
        (new LogX('vfs://root/test.log'))->
            log(LogLevel::ALERT, 'message', ['time_output' => false]);
        $logContents = file_get_contents('vfs://root/test.log');
        self::assertEquals("[alert] message\n", $logContents);
        vfsStream::setup();
        (new LogX('vfs://root/test.log'))->
            enableTimeOutput(false)->
            log(LogLevel::ALERT, 'message');
        $logContents = file_get_contents('vfs://root/test.log');
        self::assertEquals("[alert] message\n", $logContents);
    }

    public function testStdoutEcho()
    {
        vfsStream::setup();
        $log = (new LogX('vfs://root/test.log'))->
            enableTimeOutput(false);
        ob_start();
        $log->log(LogLevel::ALERT, 'message', ['stdout_echo' => true]);
        $logContents = ob_get_clean();
        self::assertEquals("[alert] message\n", $logContents);
        ob_start();
        $log->enableStdoutEcho()->
            log(LogLevel::ALERT, 'message');
        $logContents = ob_get_clean();
        self::assertEquals("[alert] message\n", $logContents);
    }

    public function testLogAppend()
    {
        vfsStream::setup();
        $log = (new LogX('vfs://root/test.log'))->
            log(LogLevel::ALERT, 'message');
        unset($log);
        new LogX('vfs://root/test.log', false);
        $logContents = file_get_contents('vfs://root/test.log');
        self::assertNotEmpty($logContents);
    }

    public function testFormatting()
    {
        vfsStream::setup();
        echo("\n\n");
        (new LogX('vfs://root/test.log'))->
            enableStdoutEcho()->
            alert('alert')->
            critical('critical')->
            debug('debug')->
            emergency('emergency')->
            error('error')->
            info('info')->
            notice('notice')->
            warning('warning')->
            log(LogLevel::ALERT, 'message', ['time_output' => false]);
    }
}
