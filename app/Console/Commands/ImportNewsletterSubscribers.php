<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use App\NewsletterSubscriber;

class ImportNewsletterSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:import {filename=newsletter_subscribers.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import subscribers';

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
        $filepath = storage_path($this->argument('filename'));

        $csv = Reader::createFromPath($filepath, 'r');

        $csv->setHeaderOffset(0);

        $rows = $csv->getRecords();

        foreach ($rows as $row) {
            $email = $row['Email address - other'];

            NewsletterSubscriber::firstOrCreate(['email' => $email]);
        }
    }
}
