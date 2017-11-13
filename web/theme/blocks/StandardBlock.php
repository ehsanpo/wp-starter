<?php

class StandardBlock extends TwigBlock {
	function __construct() {
		$this->id = 'StandardBlock';
		$this->name = 'Standard Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_59fb95e9ef677',
			'label' => 'ID',
			'name' => 'standard_id',
			'_name' => 'standard_id',
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
			'key' => 'field_55a38b71df0cf',
			'label' => 'Bild',
			'name' => 'stn_image',
			'_name' => '_stn_image',
			'type' => 'image',
			'instructions' => 'JPG or PNG',
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'mime_types' => 'png, jpg',
		);
		$fields[] = array(
			'key' => 'field_57fb8ef9f7c90',
			'label' => 'Theme',
			'name' => 'stn_tema',
			'_name' => 'stn_tema',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'dark' => 'Dark',
				'light' => 'Light',
			),
			'default_value' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'disabled' => 0,
			'readonly' => 0,
		);

		$fields[] = array(
			'key' => 'field_55a38b3ddf0cd',
			'label' => 'Headline',
			'name' => 'stn_headline',
			'_name' => 'stn_headline',
			'type' => 'text',
		);

		$fields[] = array(
			'key' => 'field_55a38b63df0ce',
			'label' => 'Body Text',
			'name' => 'body_text',
			'_name' => 'body_text',
			'type' => 'wysiwyg',
			'tabs' => 'visual',
			'toolbar' => 'basic',
			'media_upload' => 0,
		);

		$fields[] = array(
			'key' => 'field_55a38dd24c498',
			'label' => 'Link',
			'name' => 'add_link',
			'_name' => 'add_link',
			'type' => 'true_false',
			'message' => 'Add link(s) to the block?',
		);

		$fields[] = array(
			'key' => 'field_55a393191488a',
			'label' => 'Links',
			'name' => 'stn_link',
			'_name' => 'stn_link',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_55a38dd24c498',
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
					'key' => 'field_55a393731488b',
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
					'key' => 'field_55a393a01488c',
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
					'key' => 'field_55ffd4e416edb',
					'label' => 'Internal Page',
					'name' => 'link_page',
					'_name' => 'link_page',
					'type' => 'page_link',
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_55a393731488b',
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
					'key' => 'field_55a3b2dc137ce',
					'label' => 'External URL',
					'name' => 'link_url',
					'_name' => 'link_url',
					'type' => 'url',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_55a393731488b',
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

new StandardBlock();
