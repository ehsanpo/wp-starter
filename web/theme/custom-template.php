<?php
/*
 * Template Name: Custom
 * Description: Full Width Template
 */

$all_posts = [];

render('empty.twig', array(
	'post' => new SitePost(),
	'all_posts' => $all_posts,
));





