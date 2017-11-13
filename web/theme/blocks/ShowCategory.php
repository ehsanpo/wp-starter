<?php

class ShowcatBlock extends TwigBlock {
	function __construct() {
		$this->id = 'ShowcatBlock';
		$this->name = 'Kategori Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'field_57fe14e19be3a',
			'label' => 'Category',
			'name' => 'category',
			'_name' => 'category',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'categories',
			'field_type' => 'checkbox',
			'allow_null' => 0,
			'add_term' => 1,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'object',
			'multiple' => 0,
		);

		$fields[] = array(
			'key' => 'field_55ffd4e446edb',
			'label' => 'Link',
			'name' => 'link_page',
			'_name' => 'link_page',
			'type' => 'page_link',
			'conditional_logic' => 0,
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
		);
	}

	function get_template_data($data) {
		$data['list'] = [];
		foreach ($data['category'] as $key => $value) {
			$data['list'][$value->term_id]['id'] = $value->term_id;
			$data['list'][$value->term_id]['name'] = $value->name;
			//$data['list'][$value->term_id]['image'] =  z_taxonomy_image_url($value->term_id);
		}
		return $data;
	}
}
