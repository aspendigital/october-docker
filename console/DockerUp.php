<?php namespace AspenDigital\Docker\Console;

use App;
use Config;
use File;
use PDO;
use October\Rain\Config\ConfigWriter;
use Illuminate\Console\Command;
use System\Classes\UpdateManager;
use System\Models\Parameter;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DockerUp extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'docker:up';

    /**
     * @var string The console command description.
     */
    protected $description = 'Creates database (sqlite) then builds tables for October and all plugins';

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
        $this->output->writeln('<info>Checking for database...</info>');

        if (App::hasDatabase()) {
          $this->output->writeln('<info>Database already exists.</info>');
        }
        else {
          $filename = Config::get('database.connections.sqlite.database');

          try {
              if (!file_exists($filename)) {
                  $directory = dirname($filename);
                  if (!is_dir($directory)) {
                      mkdir($directory, 0777, true);
                  }

                  new PDO('sqlite:'.$filename);
              }
          }
          catch (Exception $ex) {
              $this->error($ex->getMessage());
          }

          $this->writeToConfig('database', ['default' => 'sqlite']);
          $this->output->writeln('<info>Database added...</info>');

          $this->call('october:up');

          if ( getenv('OCTOBERCMS_CORE_HASH') && getenv('OCTOBERCMS_CORE_BUILD') )
          {
              $this->output->writeln('<info>Setting system core parameters...</info>');
              $this->output->writeln(' - build: <info>' . getenv('OCTOBERCMS_CORE_BUILD') . '</info>');
              $this->output->writeln(' - hash: <info>' . getenv('OCTOBERCMS_CORE_HASH') . '</info>');

              Parameter::set([
                  'system::core.build' => getenv('OCTOBERCMS_CORE_BUILD'),
                  'system::core.hash'  => getenv('OCTOBERCMS_CORE_HASH')
              ]);
          }

        }
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
