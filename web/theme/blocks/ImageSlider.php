<?php

class ImageSlider extends TwigBlock {
	function __construct() {
		$this->id = 'ImageSlider';
		$this->name = 'Image Slider Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
		'key' => 'field_57fb95cfc44e8',
			'label' => 'ID',
			'name' => 'ImageSlider_id',
			'_name' => 'ImageSlider_id',
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
			'key' => 'field_57fb955d0eef2',
			'label' => 'Images',
			'name' => 'ImageSlider_Images',
			'_name' => 'ImageSlider_Images',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Image',
			'sub_fields' => array (
				array (
					'key' => 'field_57fb8d57da87d',
					'label' => 'Image',
					'name' => 'Image',
					'_name' => 'Image',
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
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array (
					'key' => 'field_57fb8d79da87e',
					'label' => 'Link',
					'name' => 'link',
					'_name' => 'link',
					'type' => 'page_link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
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
					'multiple' => 0,
				),
			),
		);
	}

	function get_template_data($data) {
		return $data;
	}
}

new ImageSlider();
