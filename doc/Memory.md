# Memory plugin

## Foreword

The memory plugin is suitable only for event dispatching within a single process. Please see the event-bus-extra-shmop (not available yet) to use shared memory instead.

## Dependencies

  * *No dependencies*

## Supported elements :

  * In process persistent publishing
  * In process subscribe

## Configuration options & defaults

| Parameter | Default | Description |
|--------------|-------------|-------------------------------------------------------------------------------------------

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

As stated above, this plugin only works "in-process". Events published with this plugin cannot cross process boundaries.
