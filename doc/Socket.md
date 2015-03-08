# File plugin

## Dependencies

  * *No dependencies*

## Supported elements :

  * Publishing
  * Subscribe

## Configuration options & defaults

| Parameter | Default | Description |
|--------------|-------------|-------------------------------------------------------------------------------------------|
| `protocol` | `ipv4` | Socket protocol to use. Accepted values are ipv4, ipv6, and ipc. |
| `host` | `127.0.0.1` | IP/Hostname to which to connect/bind. |
| `port` | `8088` | Port to which to connect/bind. |

## Usage

```php

use \Aztech\Events\Event;
use \Aztech\Events\Bus\Events;
use \Aztech\Events\Bus\Plugins;

include __DIR__ . '/vendor/autoload.php';

Plugins::loadSocketPlugin('socket');

$options = array();
$publisher = Events::createPublisher('socket', $options);

// Create and publish an event.
$event = Events::create('event.topic', array('property' => 'value'));
$publisher->publish($event);

$application = Events::createApplication('socket', $options);
$application->on('#', function(Event $event) {
    echo $event->getCategory() . ' : received event #' . $event->getId();
});

// This call is blocking
$application->run();

```

## Caveats

If a publisher has no listeners, events will be dropped.
