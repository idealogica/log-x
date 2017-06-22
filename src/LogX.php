<?php
namespace Idealogica;

use Exception;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;

class LogX extends AbstractLogger
{
    /**
     * Log file name.
     *
     * @var string
     */
    protected $fileName = '';

    /**
     * Shows that log file should be truncated before log session.
     *
     * @var string
     */
    protected $truncateFile = '';

    /**
     * File resource.
     *
     * @var resource
     */
    protected $logFile = null;

    /**
     * Output switch for stdout.
     *
     * @var bool
     */
    protected $stdoutEcho = false;

    /**
     * Output switch for timestamp.
     *
     * @var bool
     */
    protected $timeOutput = true;

    /**
     * Constructor.
     *
     * @param string $fileName
     * @param bool $truncateFile
     *
     * @throws Exception
     */
    public function __construct($fileName, $truncateFile = true)
    {
        $this->fileName = $fileName;
        $this->truncateFile = $truncateFile;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        if ($this->logFile) {
            fclose($this->logFile);
        }
    }

    /**
     * Enables echo output to stdout.
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function enableStdoutEcho($enable = true)
    {
        $this->stdoutEcho = $enable;
        return $this;
    }

    /**
     * Enables timestamp output.
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function enableTimeOutput($enable = true)
    {
        $this->timeOutput = $enable;
        return $this;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return null
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        if (!$level) {
            throw new InvalidArgumentException('Log level must be specified');
        }
        if (!$message) {
            throw new InvalidArgumentException('Message must be specified');
        }
        if (!defined('Psr\Log\LogLevel::' . strtoupper($level))) {
            throw new InvalidArgumentException('Unknown log level');
        }
        $logMsg = '';
        $timeOutput = isset($context['time_output']) ?
            $context['time_output'] :
            $this->timeOutput;
        $stdoutEcho = isset($context['stdout_echo']) ?
            $context['stdout_echo'] :
            $this->stdoutEcho;
        $exceptionMsg =
            !empty($context['exception']) && $context['exception'] instanceof Exception ?
                ' (' . $context['exception']->getMessage() . ')' :
                '';
        $logMsg .= $timeOutput ? date('Y-m-d H:i:s') . ' ' : '';
        $logMsg .= '[' . $level . '] ' . (string)$message . $exceptionMsg . "\n";
        fwrite($this->getLogFileResource(), $logMsg);
        if ($stdoutEcho) {
            echo($logMsg);
        }
        return null;
    }

    /**
     * Returns log file resource.
     *
     * @return resource
     * @throws Exception
     */
    protected function getLogFileResource()
    {
        if (!$this->logFile) {
            $this->logFile = @fopen($this->fileName, $this->truncateFile ? 'w' : 'a');
            if ($this->logFile === false) {
                throw new Exception("Can't create file " . $this->fileName . " to log into.");
            }
        }
        return $this->logFile;
    }
}
