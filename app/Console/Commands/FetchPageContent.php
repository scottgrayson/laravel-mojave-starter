<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\HTMLToMarkdown\HtmlConverter;
use DiDom\Document;
use App\Page;
use App\File;
use App\Image;
use Illuminate\Support\Facades\Storage;

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

    protected $baseUrl;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->baseUrl = 'http://www.missbettysdaycamp.org';
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
            $fullUrl = $this->baseUrl . $uri;

            $document = new Document($fullUrl, true);

            $this->replaceImages($document);

            $res = $document->find('title');
            $title = count($res) ? $res[0]->text() : '';

            $res = $document->find('meta[property=og:description]');
            $description = count($res) ? $res[0]->getAttribute('content') : '';

            $res = $document->find('#wsite-content');
            $content = count($res) ? $res[0]->html() : '';
            $markdown = str_replace('.html', '', trim($converter->convert($content)));

            $newUri = str_replace('.html', '', $uri);

            Page::updateOrCreate(
                ['uri' => $newUri],
                [
                    'uri' => $newUri,
                    'name' => $title ? $title : $uri,
                    'title' => $title,
                    'meta_description' => $description,
                    'content' => $uri === '/' ? 'admin managed content' : $markdown,
                    'published' => 1,
                ]
            );
        });
    }

    protected function replaceImages($document)
    {
        foreach ($document->find('img') as $img) {
            if ($img->getAttribute('alt') === 'Quantcast') {
                continue; //ignore tracking pixel img
            }

            $url = $this->baseUrl . preg_replace('/\?.*/', '', $img->getAttribute('src'));

            $filename = basename($url);
            $prefix = dirname($url);
            // get the fullsize image
            $origUrl = $prefix . '/' . str_replace('.', '_orig.', $filename);

            try {
                $image = file_get_contents($origUrl);
            } catch (\Exception $e) {
                $image = file_get_contents($url);
            }

            $storagePath = 'uploads/'.$filename;
            Storage::put($storagePath, $image);


            $fileModel = \App\File::createFromStoragePath($storagePath, $filename);

            $imageModel = \App\Image::create(
                [
                    'name' => $filename,
                    'file_id' => $fileModel->id,
                    'user_id' => auth()->check() ? request()->user()->id : null,
                ]
            );

            $img->setAttribute('src', '/storage/'.$storagePath);

            // remove any image links because they go to old site
            $parent = $img->parent();
            if ($parent->tag === 'a') {
                $parent->replace($img);
            }
        }
    }

    protected function urls()
    {
        // get all results from search page. and load unique links
        $fullUrl = $this->baseUrl . '/apps/search?q=%2A&filter=page';

        $document = new Document($fullUrl, true);
        $links = $document->find('a[href]');

        $uriArr = [];

        foreach ($links as $link) {
            $href = $link->getAttribute('href');

            // pages are homepage or end in url.
            // they are relative urls
            $isPage = (strpos($href, '.html') !== false || $href = '/') && strpos($href, '.com') === false;

            if ($isPage && !in_array($href, $uriArr)) {
                $uriArr []= $href;
            }
        }

        return $uriArr;
    }
}
