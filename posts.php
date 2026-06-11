<?php

// Load Composer's autoload
require_once __DIR__ . '/vendor/autoload.php';

// Load the RSS feed
$feed = Feed::loadRss('https://yellowraincoat.co.uk/blog/feed/rss/')->toArray();

// Generate the list of blog posts
$posts = '';
foreach (array_slice($feed['item'], 0, 5) as $post) {
    $posts .= sprintf("\n* [%s](%s \"%s\")", $post['title'], $post['link'], $post['title']);
}

// Generate the new content
$content = preg_replace(
    '#<!-- posts -->.*<!-- /posts -->#s',
    sprintf('<!-- posts -->%s<!-- /posts -->', $posts),
    file_get_contents('README.md')
);

// Overwrite the file
file_put_contents('README.md', $content);
