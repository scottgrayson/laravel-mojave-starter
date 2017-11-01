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
        $converter = new HtmlConverter([
            'header_style' => 'atx', // Set to 'atx' to output H1 and H2 headers as # Header1 and ## Header2
            'suppress_errors' => true, // Set to false to show warnings when loading malformed HTML
            'strip_tags' => true, // Set to true to strip tags that don't have markdown equivalents. N.B. Strips tags, not their content. Useful to clean MS Word HTML output.
            'bold_style' => '**', // Set to '__' if you prefer the underlined style
            'italic_style' => '*', // Set to '*' if you prefer the asterisk style
            'remove_nodes' => '', // space-separated list of dom nodes that should be removed. example: 'meta style script'
            'hard_break' => true, // Set to true to turn <br> into `\n` instead of `  \n`
            'list_item_style' => '*', // Set the default character for each <li> in a <ul>. Can be '-', '*', or
        ]);

        collect($this->urls())->each(function ($uri) use ($converter) {
            $uriWithSuffix = !$uri ? $uri : $uri.'.html';
            $fullUrl = 'http://www.missbettysdaycamp.org/' . $uriWithSuffix;

            $document = new Document($fullUrl, true);

            $res = $document->find('title');
            $title = count($res) ? $res[0]->text() : '';

            $res = $document->find('meta[property=og:description]');
            $description = count($res) ? $res[0]->getAttribute('content') : '';

            $res = $document->find('#wsite-content');
            $content = count($res) ? $res[0]->html() : '';
            $markdown = str_replace('.html', '', trim($converter->convert($content)));

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
