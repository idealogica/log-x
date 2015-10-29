# Log-X

Log-X it's a simple PSR-3 compliant logger with ability to duplicate log entries to stdout.

### Installation

Log-X requires PHP >= 5.4

```
composer require idealogica/log-x:~1.0.0
```

### Example

```
(new Idealogica\LogX('test.log', false))->
    enableStdoutEcho()->
    alert('Alert message')->
    critical('Critial message')->
    debug('Debug message')->
    emergency('Emergency message')->
    error('Error message', ['exception' => new \Exception('Kind of exception!')])->
    info('Info message')->
    notice('Notice message', ['time_output' => false])->
    warning('Warning message', ['stdout_echo' => false]);
```

### License

Log-X is licensed under a [MIT License](https://opensource.org/licenses/MIT).