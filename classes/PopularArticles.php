<?php

namespace Grav\Plugin\PopularArticles;

use Grav\Common\Grav;
use Grav\Plugin\Admin\Popularity;
use Grav\Common\Page\Collection;

class PopularArticles
{
    private $popularityFile;
    private $grav;
    private $articles;

    public function __construct()
    {
        $this->grav = Grav::instance();

        // Admin plugin is required
        $this->popularityFile = $this->grav['locator']->findResource('log://popularity', true, true)
            . DIRECTORY_SEPARATOR
            . Popularity::TOTALS_FILE;
    }

    public function get()
    {
        if ( !$this->articles ) $this->articles = $this->build();

        return $this->articles;
    }

    public function build()
    {
        // Get config or default
        $NUMBER_OF_ARTICLES = $this->grav['config']->get('plugins.popular-articles.articles_count') ?? 5;
        $BLOG_ROUTE = $this->grav['config']->get('plugins.popular-articles.blog_route') ?? '/blog';

        $popularityData = [];

        if ( file_exists($this->popularityFile) ) {
            // Read json from popularity file
            $popularityData = (array)json_decode(
                file_get_contents($this->popularityFile),
                true
            );

            // Sort data by number of visits desc
            arsort( $popularityData );

            // Filter on existing pages
            $popularityData = array_filter(
                $popularityData,
                function($key) use ($BLOG_ROUTE) {
                    $page = $this->grav['page']->find($key);
                    return $page !== null && strpos($key, $BLOG_ROUTE . '/') === 0;
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        // Limit number of articles returned
        $popularityData = array_slice($popularityData, 0, $NUMBER_OF_ARTICLES);

        // Return the collection of pages
        $pagesCollection = new Collection();

        foreach($popularityData as $route => $count) {
            $page = $this->grav['page']->find($route);

            $pagesCollection->addPage($page);
        }

        return $pagesCollection;
    }
}