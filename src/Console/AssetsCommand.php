<?php

namespace Herode\Amana\Console;

use Illuminate\Console\Command;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amana:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the Amana assets';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'amana-assets',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'amana-fonts',
            '--force' => true,
        ]);
    }
}
