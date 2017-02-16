<?php namespace AspenDigital\Docker\Console;

use App;
use Config;
use File;
use PDO;
use October\Rain\Config\ConfigWriter;
use Illuminate\Console\Command;
use System\Classes\UpdateManager;
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

          // Run october:up
          $manager = UpdateManager::instance()->resetNotes()->update();

          $this->output->writeln('<info>Migrating application and plugins...</info>');

          foreach ($manager->getNotes() as $note) {
              $this->output->writeln($note);
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
