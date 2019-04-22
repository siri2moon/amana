<?php

namespace Herode\Amana\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amana:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Amana resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Amana Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'amana-assets']);

        $this->comment('Publishing Amana Fonts...');
        $this->callSilent('vendor:publish', ['--tag' => 'amana-fonts']);

        $this->comment('Publishing Amana Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'amana-config']);

        $this->comment('Publishing Amana Migration...');
        $this->callSilent('vendor:publish', ['--tag' => 'amana-migrations']);


        $this->info('Amana scaffolding installed successfully.');
    }
}
