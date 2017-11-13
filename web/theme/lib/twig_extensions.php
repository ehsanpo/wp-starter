<?php

/*
 * Extension to Twig that helps with rendering sections.
 */
class Twig_Renderer {
	static $twig;

	function __construct($twig) {
		self::$twig = $twig;
	}

	function sections($field) {
		return Blocks::render($field);
	}

	function section($id, $data) {
		return Blocks::render_single($id, $data);
	}

	function main_content($blocks) {
		if(empty($blocks)) return;

		foreach($blocks as $block) {
			if($block['acf_section'] == 'shared-content') {
				$block['toplevel'] = true;
				Blocks::render_single($block['acf_section'], $block);

			} else if($block['acf_section'] == 'section') {
				Blocks::render_single($block['acf_section'], $block);

			}else if($block['acf_section'] == 'latest-posts') {
				Blocks::render_single($block['acf_section'], $block);
				
			} else {
				echo '<div class="section section--no-padding"><div class="wrapper">';
				Blocks::render_single($block['acf_section'], $block);
				echo '</div></div>';
			}
		}
	}
}

/**
 * Quick and dirty way to do a Timber rendering.
 */
function render($templates, $extra_context) {
	$ctx = Timber::get_context();
	if(! empty($extra_context)) {
		$ctx = array_merge($ctx, $extra_context);
	}
	Timber::render($templates, $ctx);
}

add_filter('twig_apply_filters', function($twig) {
	$twig->addGlobal('render', new Twig_Renderer($twig));
	return $twig;
});
