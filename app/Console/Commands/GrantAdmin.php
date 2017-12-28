<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class GrantAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give an existing user admin permissions.';

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
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found with email: '. $email);
            return;
        }

        $user->assignRole('admin');
        $this->info('Admin access granted to: '. $email);
    }
}
