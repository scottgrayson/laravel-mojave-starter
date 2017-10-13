<?php

namespace App\Observers;

use App\Newsletter;
use App\NewsletterUrl;

class NewsletterObserver
{
    public function saved(Newsletter $newsletter)
    {
        if ($newsletter->isDirty('body')) {
            $body = $this->subUrls(
                $newsletter->body,
                $newsletter->id
            );

            // sql so that this does not infinite loop
            Newsletter::where('id', $newsletter->id)
                ->update(['body' => $body]);
        }
    }

    private function subUrls($body, $id)
    {
        preg_match_all(
            '/href=[\'"]([^\'"]+)[\'"]/',
            $body,
            $matches
        );


        // check if the url is already a tracked url
        $urls = array_filter($matches[1], function ($url) {
            return !preg_match("/newsletters\/short/", $url);
        });

        $replacements = array_map(function ($url) use ($id) {
            $trackableUrl = NewsletterUrl::firstOrCreate([
                'newsletter_id' => $id,
                'target' => $url
            ])->trackableUrl;

            return [
                'target' => $url,
                'tracked' => $trackableUrl
            ];
        }, $urls);

        foreach ($replacements as $r) {
            $body = str_replace($r['target'], $r['tracked'], $body);
        }

        return $body;
    }
}
