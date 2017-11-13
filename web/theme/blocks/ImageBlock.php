<?php

class ImageBlock extends TwigBlock {
	function __construct() {
		$this->id = 'ImageBlock';
		$this->name = 'Image Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_57fb94fbe79c7',
			'label' => 'Image',
			'name' => 'image',
			'_name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
		);
		$fields[] = array (
			'key' => 'field_58fb9566e79d8',
			'label' => 'Parallax',
			'name' => 'parallax',
			'_name' => 'parallax',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			);
		$fields[] = array (
			'key' => 'field_58fb95e9ef667',
			'label' => 'ID',
			'name' => 'image_id',
			'_name' => 'image_id',
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
	}

	function get_template_data($data) {
		return $data;
	}
}

new ImageBlock();
