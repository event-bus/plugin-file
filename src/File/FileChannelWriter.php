<?php

namespace Aztech\Events\Bus\Plugins\File;

use Aztech\Events\Event;
use Aztech\Events\Bus\Channel\ChannelWriter;

class FileChannelWriter implements ChannelWriter
{
    private $file;

    private $lock;

    public function __construct($file)
    {
        $this->file = $file;
        $this->lock = new FileLock($file);
    }

    public function write(Event $event, $serializedEvent)
    {
        if ($handle = fopen($this->file, "c+")) {
            if ($this->lock->invokeEx(array($this, 'append'), $handle, $serializedEvent)) {
                fflush($handle);
            }

            fclose($handle);
        }
    }

    public function append($handle, $data)
    {
        while (fgets($handle) !== false) {
            continue;
        }

        fwrite($handle, $data . PHP_EOL);
    }

    /**
     * Performs necessary dispose work
     */
    function dispose()
    {
        unset($this->lock);
    }
}
