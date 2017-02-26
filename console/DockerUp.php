<?php namespace AspenDigital\Docker\Console;

use App;
use Illuminate\Console\Command;
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
    protected $description = 'Set October CMS core build and hash';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        if (App::hasDatabase())
        {
            if ( getenv('OCTOBERCMS_CORE_HASH') && getenv('OCTOBERCMS_CORE_BUILD') )
            {
                $this->output->writeln('<info>Setting system core parameters</info>');
                $this->output->writeln(' - build: <info>' . getenv('OCTOBERCMS_CORE_BUILD') . '</info>');
                $this->output->writeln(' - hash: <info>' . getenv('OCTOBERCMS_CORE_HASH') . '</info>');

                Parameter::set([
                    'system::core.build' => getenv('OCTOBERCMS_CORE_BUILD'),
                    'system::core.hash'  => getenv('OCTOBERCMS_CORE_HASH')
                ]);
            }
        }
        else
        {
          $this->output->writeln('<info>Database not found. Failed to set core parameters.</info>');
        }
    }

}
