<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\HTMLToMarkdown\HtmlConverter;
use DiDom\Document;
use App\Page;

class FetchPageContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch page content from old site';

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
        $converter = new HtmlConverter(['strip_tags' => true]);

        collect($this->urls())->each(function ($uri) use ($converter) {
            $uriWithSuffix = !$uri ? $uri : $uri.'.html';
            $fullUrl = 'http://www.missbettysdaycamp.org/' . $uriWithSuffix;

            $document = new Document($fullUrl, true);

            $res = $document->find('title');
            $title = count($res) ? $res[0]->text() : '';

            $res = $document->find('meta[type=description]');
            $description = count($res) ? $res[0]->getAttribute('content') : '';

            $res = $document->find('#wsite-content');
            $content = count($res) ? $res[0]->html() : '';
            $markdown = trim($converter->convert($content));

            Page::updateOrCreate(
                ['uri' => '/'.$uri],
                [
                    'uri' => '/'.$uri,
                    'name' => $title ? $title : $uri,
                    'title' => $title,
                    'meta_description' => $description,
                    'content' => $markdown,
                    'published' => 1,
                ]
            );
        });
    }

    protected function urls()
    {
        return [
            '',
            'history',
            'rules-and-regulations',
        ];
    }
}
