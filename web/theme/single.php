<?php
$post = new TimberPost();
render('single.twig', array(
	'post' => $post
));
