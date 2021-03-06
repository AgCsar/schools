<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TokenUserTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a user token test.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tokens = \Tests\TestCase::getTokenUserTester();
        dump($tokens);
    }
}
