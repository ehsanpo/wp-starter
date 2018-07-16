<?php

class videoBlock extends TwigBlock {
	function __construct() {
		$this->id = "video-block";
		$this->name = "Video Block";

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_5afd42ec9ac5c',
			'label' => 'Preview image',
			'name' => 'preview_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		);
		$fields[] = array(
			'key' => 'field_5afd43279ac5d',
			'label' => 'Preview video',
			'name' => 'preview_video',
			'type' => 'file',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => '',
		);
		$fields[] = array(
			'key' => 'field_5afd433c9ac5e',
			'label' => 'Video Iframe',
			'name' => 'video_iframe',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'https://',
		);
		
	}

	function get_template_data($data) {
		return $data;
	}
}

new videoBlock();

