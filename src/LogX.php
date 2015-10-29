<?php
namespace Idealogica;

use Exception;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;

class LogX extends AbstractLogger
{
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
     * @param bool $trucateFile
     *
     * @throws Exception
     */
    public function __construct($fileName, $trucateFile = true)
    {
        $this->logFile = fopen($fileName, $trucateFile ? 'w' : 'a');
        if($this->logFile === false)
        {
            throw new Exception("Can't create file ".$fileName." to log into.");
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        fclose($this->logFile);
    }

    /**
     * Enables echo output to stdout.
     *
     * @param bool $enable
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
     * @return $this
     */
    public function enableTimeOutput($enable = true)
    {
        $this->timeOutput = $enable;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function emergency($message, array $context = array())
    {
        parent::emergency($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function alert($message, array $context = array())
    {
        parent::alert($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function critical($message, array $context = array())
    {
        parent::critical($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function error($message, array $context = array())
    {
        parent::error($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function warning($message, array $context = array())
    {
        parent::warning($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function notice($message, array $context = array())
    {
        parent::notice($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function info($message, array $context = array())
    {
        parent::info($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function debug($message, array $context = array())
    {
        parent::debug($message, $context);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        if(!$level)
        {
            throw new InvalidArgumentException('Log level must be specified');
        }
        if(!$message)
        {
            throw new InvalidArgumentException('Message must be specified');
        }
        if(!defined('Psr\Log\LogLevel::'.strtoupper($level)))
        {
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
                ' ('.$context['exception']->getMessage().')' :
                '';
        $logMsg .= $timeOutput ? date('Y-m-d H:i:s').' ' : '';
        $logMsg .= '['.$level.'] '.(string)$message.$exceptionMsg."\n";
        fwrite($this->logFile, $logMsg);
        if($stdoutEcho)
        {
            echo($logMsg);
        }
        return $this;
    }
}
