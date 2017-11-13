<?php

class LatestPostsBlock extends TwigBlock {
	function __construct() {
		$this->id = 'LatestPosts';
		$this->name = 'Latest Posts Block';

		parent::__construct();
	}
	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_59fb95e9ef347',
			'label' => 'ID',
			'name' => 'blog_id',
			'_name' => 'blog_id',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		);
		$fields[] = array(
			'key' => 'field_56b48b3ddf5cd',
			'label' => 'Headline',
			'name' => 'news_headline',
			'_name' => 'news_headline',
			'type' => 'text',
		);
		$fields[] = array(
			'key' => 'field_58b28b63df0ce',
			'label' => 'Body Text',
			'name' => 'body_text',
			'_name' => 'body_text',
			'type' => 'wysiwyg',
			'tabs' => 'visual',
			'toolbar' => 'basic',
			'media_upload' => 0,
		);
	}

	function get_template_data($data) {
		return array(
			'posts' => Timber::get_posts('numberposts=3'),
			'data' => $data
		);
	}
}

new LatestPostsBlock();
