<?php

namespace Aztech\Events\Bus\Plugins\File;

use Aztech\Events\Bus\Channel\ChannelReader;

class FileChannelReader implements ChannelReader
{

    private $file;

    private $lock;

    public function __construct($file)
    {
        $this->file = $file;
        $this->lock = new FileLock($file);
    }

    public function read()
    {
        $data = false;

        while (! $data) {
            $data = $this->readNextLine();
            $this->checkDataBlock($data);
        }

        return $data;
    }

    private function readNextLine()
    {
        $data = false;

        if ($handle = fopen($this->file, "c+")) {
            $data = $this->lock->invokeEx(array(
                $this,
                'readAndRemoveFirstLine'
            ), $handle);

            fclose($handle);
        }

        return $data;
    }

    private function checkDataBlock($data)
    {
        // @codeCoverageIgnoreStart
        if (! $data) {
            usleep(250000);
        }
        // @codeCoverageIgnoreEnd
    }

    public function readAndRemoveFirstLine($handle)
    {
        $lines = array();
        $data = false;

        while (($line = fgets($handle)) !== false) {
            if ($data) {
                $lines[] = trim($line);
            }
            elseif (trim($line) != '') {
                $data = trim($line);
            }
        }

        file_put_contents($this->file, implode(PHP_EOL, $lines));

        return $data;
    }

    /**
     * Performs necessary cleanup work.
     */
    function dispose()
    {
        unset($this->lock);
    }
}
