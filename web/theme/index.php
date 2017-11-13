<?php

$templates = array('index.twig');
if(is_home()) {
	array_unshift($templates, 'home.twig');
}

render($templates, array(
	'posts' => Timber::get_posts()
));
