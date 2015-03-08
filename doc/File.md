# File plugin

## Dependencies

  * *No dependencies*

## Supported elements :

  * Persistant publishing
  * Subscribe

## Configuration options & defaults

| Parameter | Default | Description |
|--------------|-------------|-------------------------------------------------------------------------------------------|
| `file` | **Required** | Path to the file used as a queue. |

## Usage

```php

use \Aztech\Events\Event;
use \Aztech\Events\Bus\Events;
use \Aztech\Events\Bus\Plugins;

include __DIR__ . '/vendor/autoload.php';

Plugins::loadFilePlugin('file');

$options = array('file' => '/tmp/events.queue');
$publisher = Events::createPublisher('file', $options);

// Create and publish an event.
$event = Events::create('event.topic', array('property' => 'value'));
$publisher->publish($event);

$application = Events::createApplication('file', $options);
$application->on('#', function(Event $event) {
    echo $event->getCategory() . ' : received event #' . $event->getId();
});

// This call is blocking
$application->run();

```

## Caveats

The file plugin uses the `flock` PHP function to perform exclusive writes on the event queue, which is known to have issues in some contexts. Please read the PHP notes on [flock](http://php.net/manual/en/function.flock.php#refsect1-function.flock-notes) for more information.
