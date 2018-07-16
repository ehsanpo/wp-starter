<?php

class heroBlock extends TwigBlock {
	function __construct() {
		$this->id = "hero-block";
		$this->name = "Hero Block";

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_5afd3f3a59f7c',
			'label' => 'Title',
			'name' => 'title',
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
			'key' => 'field_5afd3f4159f7d',
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

		$fields[] = array(
			'key' => 'field_5afd40325c624',
			'label' => 'background image',
			'name' => 'background_image',
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
			'key' => 'field_11a38dd24c498',
			'label' => 'Link',
			'name' => 'add_link',
			'_name' => 'add_link',
			'type' => 'true_false',
			'message' => 'Add link(s) to the block?',
		);

		$fields[] = array(
			'key' => 'field_11a393191488a',
			'label' => 'Links',
			'name' => 'stn_link',
			'_name' => 'stn_link',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_11a38dd24c498',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'min' => 1,
			'max' => '',
			'layout' => 'block',
			'button_label' => 'Add another link',
			'sub_fields' => array (
				array (
					'key' => 'field_11a393731488b',
					'label' => 'Type',
					'name' => 'link_type',
					'_name' => 'link_type',
					'type' => 'radio',
					'required' => 1,
					'choices' => array (
						'page' => 'Page',
						'url' => 'URL',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'layout' => 'horizontal',
				),
				array (
					'key' => 'field_11a393a01488c',
					'label' => 'Text',
					'name' => 'link_text',
					'_name' => 'link_text',
					'type' => 'text',
					'required' => 1,
					'wrapper' => array (
						'width' => 50,
					),
				),
				array (
					'key' => 'field_11ffd4e416edb',
					'label' => 'Internal Page',
					'name' => 'link_page',
					'_name' => 'link_page',
					'type' => 'page_link',
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_11a393731488b',
								'operator' => '==',
								'value' => 'page',
							),
						),
					),
					'wrapper' => array (
						'width' => 50,
					),
					'post_type' => array (
						0 => 'page',
						1 => 'post',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_11a3b2dc137ce',
					'label' => 'External URL',
					'name' => 'link_url',
					'_name' => 'link_url',
					'type' => 'url',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_11a393731488b',
								'operator' => '==',
								'value' => 'url',
							),
						),
					),
					'wrapper' => array (
						'width' => 50,
					),
					'placeholder' => 'http://',
					'default_value' => 'http://',
				),
			),
		);
		
	}

	function get_template_data($data) {
		return $data;
	}
}

new heroBlock();

