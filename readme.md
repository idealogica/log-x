# Log-x

Log-x it's a simple PSR-3 compliant logger with ability to dublicate output to stdout.

### Installation

Log-x requires PHP >= 5.4

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

Log-x is licensed under a [MIT License](https://opensource.org/licenses/MIT).