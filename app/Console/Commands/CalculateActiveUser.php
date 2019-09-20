<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $signature = 'garfield-bbs:calculate-active-user';
=======
    protected $signature = 'larabbs:calculate-active-user';
>>>>>>> L03_5.8

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate active users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        // Print a line of information on the command line
        $this->info("Start calculating...");

        $user->calculateAndCacheActiveUsers();

        $this->info("Successfully generated.");
    }
}
