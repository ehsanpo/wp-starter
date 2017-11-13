<?php

class SharedContentBlock extends Block {
	function __construct() {
		$this->id = 'shared-content';
		$this->name = 'Shared Content Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'shared_content',
			'name' => 'id',
			'label' => __('Select content', I18N_THEME),
			'type' => 'post_object',
			'required' => 1,
			'post_type' => array('shared-content'),
			'taxonomy' => array(),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1
		);
	}

	function render($data, $styles) {
		if(! empty($data['toplevel'])) {
			return $this->render_toplevel($data, $styles);
		}

		$sections = get_field('sections', $data['id']);
		Blocks::render($sections);
	}

	function render_toplevel($data, $styles) {
		$blocks = get_field('sections', $data['id']);
		if(empty($blocks)) return;

		foreach($blocks as $block) {
			if($block['acf_section'] == 'shared-content') {
				$block['toplevel'] = true;
				Blocks::render_single($block['acf_section'], $block);
			} else if($block['acf_section'] == 'section') {
				Blocks::render_single($block['acf_section'], $block);
			} else {
				echo '<div class="section"><div class="wrapper">';
				Blocks::render_single($block['acf_section'], $block);
				echo '</div></div>';
			}
		}
	}
}

new SharedContentBlock();
