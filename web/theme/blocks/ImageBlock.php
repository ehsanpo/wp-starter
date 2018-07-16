<?php

class ImageBlock extends TwigBlock {
	function __construct() {
		$this->id = 'ImageBlock';
		$this->name = 'Image Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_66fd48ad0c399',
			'label' => 'Text Color',
			'name' => 'text_color',
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
				"text-white" => "White",
				"text-black" => "Black"
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => "text-black",
			'layout' => 'horizontal',
		);
		$fields[] = array(
			'key' => 'field_77fd48ad0c399',
			'label' => 'Image Padding',
			'name' => 'image_padding',
			'type' => 'radio',
			'instructions' => 'How big the image will be.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 50,
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				"big-padding" => "Big",
				"small-padding" => "Small"
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => "black",
			'layout' => 'horizontal',
		);
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

		$fields[] = array(
			'key' => 'field_5bfd3f4159f6d',
			'label' => 'Body text',
			'name' => 'body_text',
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
