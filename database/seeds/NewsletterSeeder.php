<?php

use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsletters = factory(\App\Newsletter::class, 10)->create();

        $subscribers = factory(\App\NewsletterSubscriber::class, 500)->create();

        $newsletterCount = $newsletters->count();

        $urls = factory(\App\NewsletterUrl::class, 50)->make()
            ->each(function ($i) use ($newsletterCount) {
                $i->newsletter_id = rand(1, $newsletterCount);
            })
            ->toArray();

        DB::table('newsletter_urls')->insert($urls);

        $opens = factory(\App\NewsletterOpen::class, 1000)->make()
            ->each(function ($i) use ($newsletterCount) {
                $i->newsletter_id = rand(1, $newsletterCount);
            })
            ->toArray();

        DB::table('newsletter_opens')->insert($opens);

        $urlCount = count($urls);

        $clicks = factory(\App\NewsletterClick::class, 500)->make()
            ->each(function ($i) use ($newsletterCount, $urlCount) {
                $i->newsletter_id = rand(1, $newsletterCount);
                $i->newsletter_url_id = rand(1, $urlCount);
            })
            ->toArray();

        DB::table('newsletter_clicks')->insert($clicks);
    }
}
