<?php
/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 08/03/15
 * Time: 05:58
 */

namespace Aztech\Events\Bus\Plugins\File;

use Aztech\Events\Bus\Channel\ChannelProvider;
use Aztech\Events\Bus\Factory\GenericOptionsDescriptor;
use Aztech\Events\Bus\Factory\OptionsDescriptor;
use Aztech\Events\Bus\PluginFactory;

class FilePluginFactory implements PluginFactory
{

    /**
     *
     * @return OptionsDescriptor
     */
    function getOptionsDescriptor()
    {
        $descriptor = new GenericOptionsDescriptor();
        $descriptor->addOption('file', true);

        return $descriptor;
    }

    /**
     *
     * @return ChannelProvider
     */
    function getChannelProvider()
    {
        return new FileChannelProvider();
    }
}
