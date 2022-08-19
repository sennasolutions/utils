<?php

namespace Senna\Utils\Console;

use Illuminate\Console\Command;
use Senna\Utils\Addons\Addons;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'senna:install {addon?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Senna resources';

    public function installMain()
    {
        // $this->comment('Publishing resources...');
        // $this->call('vendor:publish', ['--provider' => 'Senna\\Admin\\SennaServiceProvider', '--tag' => 'config']);
        // $this->call('vendor:publish', ['--provider' => 'Senna\\Admin\\SennaServiceProvider', '--tag' => 'migrations']);
        // $this->info('Senna installed successfully.');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Addons::install($this);
    }

}
