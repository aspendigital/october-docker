<?php namespace AspenDigital\Docker\Console;

use Config;
use File;
use October\Rain\Config\ConfigWriter;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DockerEdge extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'docker:edge';

    /**
     * @var string The console command description.
     */
    protected $description = 'Enable core and edge updates';

    /**
     * @var October\Rain\Config\ConfigWriter
     */
    protected $configWriter;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->configWriter = new ConfigWriter;
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $disableCore = false;
        $edgeUpdates = true;

        if ($this->option('disable')) {
            $disableCore = true;
            $edgeUpdates = false;
            $this->output->writeln('<info>Disabled core/edge updates</info>');
        }
        else {
            $this->output->writeln('<info>Enabled core/edge updates</info>');
        }

        $this->writeToConfig('cms', [
          'disableCoreUpdates' => $disableCore,
          'edgeUpdates' => $edgeUpdates
        ]);

        if ($edgeUpdates && $this->option('update')) {
          $this->call('october:update');
          $this->call('cache:clear');
        }

        $this->call('docker:info');
    }

    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['update', null, InputOption::VALUE_NONE, 'Enable edge updates and automatically run october:update'],
            ['disable', null, InputOption::VALUE_NONE, 'Disable edge updates']
        ];
    }

    protected function writeToConfig($file, $values)
    {
        $configFile = $this->getConfigFile($file);

        foreach ($values as $key => $value) {
            Config::set($file.'.'.$key, $value);
        }

        $this->configWriter->toFile($configFile, $values);
    }

    /**
     * Get a config file and contents.
     *
     * @return array
     */
    protected function getConfigFile($name = 'app')
    {
        $env = $this->option('env') ? $this->option('env').'/' : '';

        $name .= '.php';

        $contents = File::get($path = $this->laravel['path.config']."/{$env}{$name}");

        return $path;
    }
}
