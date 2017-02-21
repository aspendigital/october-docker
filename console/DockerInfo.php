<?php namespace AspenDigital\Docker\Console;

use Config;
use Illuminate\Console\Command;
use System\Models\Parameter;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DockerInfo extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'docker:info';

    /**
     * @var string The console command description.
     */
    protected $description = "Display container's October CMS info";


    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $hash = Parameter::get('system::core.hash');
        $build = Parameter::get('system::core.build');
        $coreUpdates = (Config::get('cms.disableCoreUpdates', false)) ? 'disabled' : 'enabled';
        $edgeUpdates = (Config::get('cms.edgeUpdates', false)) ? 'enabled' : 'disabled';

        $this->output->writeln("October CMS info");
        $this->output->writeln(" - build: <info>$build</info>");
        $this->output->writeln(" - hash: <info>$hash</info>");
        $this->output->writeln(" - core updates: <info>$coreUpdates</info>");
        $this->output->writeln(" - edge updates: <info>$edgeUpdates</info>");
    }

}
