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
            'homepage'    => 'https://github.com/aspendigital/october-docker'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('docker:up', 'AspenDigital\Docker\Console\DockerUp');
        $this->registerConsoleCommand('docker:edge', 'AspenDigital\Docker\Console\DockerEdge');
        $this->registerConsoleCommand('docker:info', 'AspenDigital\Docker\Console\DockerInfo');
    }

}
