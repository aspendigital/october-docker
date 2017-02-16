<?php namespace AspenDigital\Docker;

use Backend;
use System\Classes\PluginBase;

/**
 * Docker Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Docker Utilties',
            'description' => 'Docker utilities for OctoberCMS',
            'author'      => 'Aspen Digital',
            'homepage'    => 'http://www.aspendigital.com'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('docker:up', 'AspenDigital\Docker\Console\DockerUp');
    }

}
