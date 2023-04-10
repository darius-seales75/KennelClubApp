<?php

return [
    'name' => 'Drool Search',
    'version' => '1.0',
    'author' => 'Your Name',
    'category' => 'Search',
    'description' => 'Adds a search bar to your site.',
    'namespace' => 'search_bar',
    'requires' => [
        'Elgg' => '3.0',
    ],
    'autoload' => [
        'search_bar' => '/mod/search_bar/classes/DroolSearch.php',
    ],
    'routes' => [
        'default:drool_search' => [
            'path' => '/drool_search',
            'controller' => \drool_search\DroolSearch::class,
        ],
    ],
];
