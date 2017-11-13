<?php

class PageComposer {
	static function for_post_types($post_types) {
		$def = array(
			'key' => 'group_54461b5a903d8',
			'title' => 'Page Composer',
			'fields' => array(
				array(
					'key' => 'field_544674429f0cb',
					'label' => __('Page Composer', I18N_THEME),
					'name' => 'sections',
					'prefix' => '',
					'type' => 'sections',
					'instructions' => __('Build up your page by adding sections here', I18N_THEME),
					'required' => 0,
					'conditional_logic' => 0,
					'sections' => array()
				)
			),
			'location' => array(),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => array('the_content')
		);

		foreach($post_types as $post_type) {
			$def['location'][] = array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => $post_type
				)
			);
		}
		
		register_field_group($def);
	}

	static function with_shared_content() {
		register_field_group(array(
			'key' => 'group_54461b5a903d7',
			'title' => 'Block Builder',
			'fields' => array(
				array(
					'key' => 'field_544674429f0ca',
					'label' => __('Content Builder', I18N_THEME),
					'name' => 'sections',
					'prefix' => '',
					'type' => 'sections',
					'instructions' => __('Create this content by adding one or more sections here.', I18N_THEME),
					'required' => 0,
					'conditional_logic' => 0,
					'sections' => array()
				)
			),
			'location' => array(array(array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'shared-content'
			))),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => array('the_content')
		));

		register_post_type('shared-content', array(
			'labels' => array(
				'name' => _x('Shared Content', 'Shared Content general name', I18N_THEME),
				'singular_name' => _x('Shared Content', 'Shared Content singular name', I18N_THEME),
				'add_new' => _x('Add New', 'Shared Content add action', I18N_THEME),
				'add_new_item' => __('Add New Shared Content', I18N_THEME),
				'edit_item' => __('Edit Shared Content', I18N_THEME),
				'new_item' => __('New Shared Content', I18N_THEME),
				'all_items' => __('All Shared Content', I18N_THEME),
				'view_item' => __('View Shared Content', I18N_THEME),
				'search_items' => __('Search Shared Content', I18N_THEME),
				'not_found' => __('No Shared Content found', I18N_THEME),
				'not_found_in_trash' => __('No Shared Content found in Trash', I18N_THEME),
				'menu_name' => __('Shared Content', I18N_THEME)
			),
			'public' => true,
			'rewrite' => false,
			'hierarchical' => false,
			'menu_position' => 20,
			'menu_icon' => 'dashicons-category',
			'supports' => array('title')
		));
	}

	static function with_blocks($blocks) {
		require __DIR__ . '/../blocks/twig.php';

		foreach($blocks as $block) {
			require __DIR__ . '/../blocks/' . $block . '.php';
		}
	}
}
