# PDO plugin

## Foreword

Using databases as event queues is not recommended, especially in replicated environments. Prefer the file or socket approach, or one of the available extra plugins instead.

## Supported elements :

  * Persistent publishing
  * Subscribe

## Configuration options & defaults

| Parameter | Default | Description |
|--------------|-------------|-------------------------------------------------------------------------------------------|
| `driver` | **Required** | PDO driver name. |
| `host` | `127.0.0.1` | Hostname of the database host. |
| `port` | `3306` | Port of the database. |
| `user` | ( *Empty* ) | Username. |
| `pass` | ( *Empty* ) | Password. |
| `database` | **Required** | Name of the database/schema to use. |
| `table` | `events` | Name of the event table. |
| `id-column` | `id` | Name of the primary column. |
| `data-column` | `data` | Name of the data column. |

## Usage

```php

use \Aztech\Events\Event;
use \Aztech\Events\Bus\Events;
use \Aztech\Events\Bus\Plugins;

include __DIR__ . '/vendor/autoload.php';

Plugins::loadPdoPlugin('pdo');

$options = array('driver' => '...');
$publisher = Events::createPublisher('pdo', $options);

// Create and publish an event.
$event = Events::create('event.topic', array('property' => 'value'));
$publisher->publish($event);

$application = Events::createApplication('pdo', $options);
$application->on('#', function(Event $event) {
    echo $event->getCategory() . ' : received event #' . $event->getId();
});

// This call is blocking
$application->run();

```
