<?php

class LatestPostsBlock extends TwigBlock {
	function __construct() {
		$this->id = 'LatestPosts';
		$this->name = 'Latest Posts Block';

		parent::__construct();
	}
	function define(&$fields) {

		$fields[] = array(
			'key' => 'field_5afd47bf0c397',
			'label' => 'Show',
			'name' => 'show',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 50,
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'last' => 'Latest news',
				'select' => 'Selected news',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'late',
			'layout' => 'horizontal',
		);
		$fields[] = array(
			'key' => 'field_5afd48530c398',
			'label' => 'Selected news list',
			'name' => 'selected_news_list',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_5afd47bf0c397',
						'operator' => '==',
						'value' => 'select',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 1,
			'return_format' => 'object',
			'ui' => 1,
		);
		$fields[] = array(
			'key' => 'field_5afd48ad0c399',
			'label' => 'How many news to show',
			'name' => 'news_to_show',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_5afd47bf0c397',
						'operator' => '==',
						'value' => 'last',
					),
				),
			),
			'wrapper' => array (
				'width' => 50,
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				2 => 2,
				3 => 3,
				4 => 4,
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 3,
			'layout' => 'horizontal',
		);
	}

	function get_template_data($data) {
		return array(
			'posts' => Timber::get_posts('numberposts=' . $data['news_to_show']),
			'data' => $data
		);
	}
}

new LatestPostsBlock();
