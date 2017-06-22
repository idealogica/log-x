# Log-X

Log-X it's a simple PSR-3 compliant logger with ability to duplicate log entries to stdout.

### Installation

Log-X requires PHP >= 5.4

```
composer require idealogica/log-x:~1.1
```

### Example

```
$logX = new LogX('vfs://root/test.log');
$logX->enableStdoutEcho();
$logX->alert('alert');
$logX->critical('critical');
$logX->debug('debug');
$logX->emergency('emergency');
$logX->error('error');
$logX->info('info');
$logX->notice('notice');
$logX->warning('warning');
$logX->log(LogLevel::ALERT, 'message', ['time_output' => false]);
```

### License

Log-X is licensed under a [MIT License](https://opensource.org/licenses/MIT).