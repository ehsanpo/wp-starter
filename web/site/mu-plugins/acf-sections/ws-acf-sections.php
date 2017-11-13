<?php

/*
Plugin Name: Sections for ACF
Version: 0.1
*/

/**
 * Manager of all types of sections.
 */
class Blocks {
	private static $types = array();

	/**
	 * Register a new section. This is automatically called when a section is created.
	 */
	public static function register(Block $type) {
		self::$types[$type->id] = $type;
	}

	/**
	 * Get a section based on its identifier.
	 */
	public static function get($id) {
		return empty(self::$types[$id]) ? null : self::$types[$id];
	}

	/**
	 * List all sections.
	 */
	public static function all() {
		return array_values(self::$types);
	}

	/**
	 * Render a list of sections.
	 */
	public static function render($data) {
		foreach($data as $section) {
			self::render_single($section['acf_section'], $section);
		}
	}

	/**
	 * Render a single section.
	 */
	public static function render_single($id, $data, $extra=array()) {
		$obj = self::get($id);
		if(! empty($obj)) {
			$styles = array();
			$styles['class'] = empty($data['acf_section_style_class']) ? '' : $data['acf_section_style_class'];

			foreach($extra as $k => $v) {
				if(empty($styles[$k])) {
					$styles[$k] = $v;
				} else {
					$styles[$k] .= ' ' . $v;
				}
			}

			$obj->render($data, $styles);
		}
	}
}

/**
 * ACF section field.
 */
class acf_field_sections extends acf_field {
	function __construct() {
		$this->name = 'sections';
		$this->label = __("Sections");
		$this->category = 'layout';

		parent::__construct();
	}

	private static $common_rendered;

	function input_admin_enqueue_scripts() {
		$dir = plugin_dir_url(__FILE__);

		wp_enqueue_script('jquery-ui-position');
		wp_register_script('ws-acf-sections', $dir . 'admin.js');
		wp_enqueue_script('ws-acf-sections');

		wp_register_style('ws-acf-sections', $dir . 'admin.css');
		wp_enqueue_style('ws-acf-sections');
	}

	function render_field($field) {
		$render_common =  false;
		if(! self::$common_rendered) {
			$render_common = true;
			self::$common_rendered = true;
		}

		echo '<div class="acf-section-editor" data-current-name="' . $field['name'] . '">';
		acf_hidden_input(array('type' => 'hidden', 'name' => $field['name']));

		echo '<div class="acf-section-empty">' . __('Get started by using the Add Block-button', 'ws-acf-sections') . '</div>';
		echo '<div class="acf-section-values">';
		if(false && empty($field['value']) && $render_common) {
			$field['value'] = array(
				array(
					'acf_section' => 'text',
					'text' => ''
				)
			);
		}

		if(! empty($field['value'])) {
			foreach($field['value'] as $i => $data) {
				$this->render_section($field, Blocks::get($data['acf_section']), 's_' . uniqid(), $data);
			}
		}
		echo '</div>';

		echo '<ul class="acf-hl"><li class="acf-fr"><a href="#" class="acf-button button button-primary button-large acf-section-add">' . __('Add block', 'ws-acf-sections') . '</a></li></ul>';

		echo '</div>';

		if($render_common) {
			echo '<div id="acf-section-clones" style="display:none">';
			foreach(Blocks::all() as $section) {
				$this->render_section($field, $section, 'acfcloneindex');
			}
			echo '</div>';

			$section_menu = array();
			foreach(Blocks::all() as $section) {
				$section_menu[] = array(
					'action' => $section->id,
					'label' => $section->name
				);
			}

			$this->render_popup('acf-sections-menu', $section_menu);

			foreach(Blocks::all() as $section) {
				$styles = array('' => __('Default Appearance', 'ws-acf-sections'));
				$styles = apply_filters('acf/section/styles', $styles);
				$styles = apply_filters('acf/section/styles/' . $section->id, $styles);

				$group = 0;
				$menu = array();
				foreach($styles as $key => $name) {
					if(is_array($name)) {
						$group++;
						$subMenu = array(
							array(
								'action' => '',
								'label' => 'Default'
							)
						);
						foreach($name as $subKey => $subName) {
							$subMenu[] = array(
								'action' => $subKey,
								'label' => $subName
							);
						}

						$menu[] = array(
							'label' => $key,
							'items' => $subMenu,
							'group' => $group
						);
					} else {
						$menu[] = array(
							'action' => $key,
							'label' => $name
						);
					}
				}

				if(! empty($menu)) {
					$this->render_popup('acf-section-style-' . $section->id, $menu);
				}
			}
		}
	}

	function render_section($field, $section, $i, $data=null) {
		echo '<div class="acf-section ' . ($i === 'acfcloneindex' ? 'acf-clone' : '') . '" data-id="' . $section->id . '" data-toggle="' . ($i === 'acfcloneindex' ? 'open' : 'closed') . '">';

		$prefix = $i === 'acfcloneindex' ? $i : $field['name'] . '[' . $i . ']';
		acf_hidden_input(array(
			'name' => $prefix . '[acf_section]',
			'value' => $section->id
		));

		acf_hidden_input(array(
			'name' => $prefix . '[acf_section_style_class]',
			'value' => empty($data['acf_section_style_class']) ? '' : $data['acf_section_style_class'],
			'data-name' => 'acf_section_style_class'
		));

		echo '<div class="acf-section-handle">';
		echo $section->name;
		echo '</div>';

		echo '<ul class="acf-section-handle-toolbar acf-hl acf-clearfix">';
		echo '<li><a class="acf-icon acf-icon-pencil -pencil small acf-section-appearance" href="#" title="' . __('Change appearance', 'ws-acf-sections') . '"></a></li>';
		echo '<li><a class="acf-icon acf-icon-minus acf-section-remove -minus small" href="#" title="' . __('Remove block', 'ws-acf-sections') . '"></i></a></li>';
		echo '</ul>';

		echo '<div class="acf-section-content acf-fields" ' . ($i === 'acfcloneindex' ? '' : 'style="display:none"') . '>';

		foreach($section->fields as $f) {
			// TODO: load existing values
			if(isset($data[$f['name']])) {
				$f['value'] = $data[$f['name']];
			}

			$f['prefix'] = $prefix;
			acf_render_field_wrap($f, 'div');
		}

		echo '</div>';

		echo '</div>';
	}

	function render_popup($id, $items) {
		$attrs = array(
			'id' => $id,
			'class' => 'acf-fc-popup acf-section-popup'
		);

		echo '<div ' . acf_esc_attr($attrs) . '>';
		echo '<ul>';
		foreach($items as $item) {
			if(! empty($item['items'])) {
				echo '<li><span class="title">' . htmlentities($item['label']) . '</span><ul data-group="' . $item['group'] . '">';
				foreach($item['items'] as $subItem) {
					echo '<li><a href="#" data-action="' . htmlentities($subItem['action']) . '">';
					echo htmlentities($subItem['label']);
					echo '</a></li>';
				}
				echo '</ul></li>';
			} else {
				echo '<li><a href="#" data-action="' . htmlentities($item['action']) . '">';
				echo htmlentities($item['label']);
				echo '</a></li>';
			}
		}
		echo '</ul>';
		echo '<span class="bit"></span>';
		echo '<a href="#" class="focus"></a>';
		echo '</div>';
	}

	function update_value($value, $post_id, $field) {
		if(isset($value['acfcloneindex'])) {
			unset($value['acfcloneindex']);
		}

		// Force empty $value to array
		if(empty($value)) $value = array();

		$data = array();
		$i = 0;
		foreach($value as $row) {
			$type = Blocks::get($row['acf_section']);
			$data[] = array(
				'id' => $type->id,
				'style_class' => $row['acf_section_style_class']
			);

			foreach($type->fields as $sub_field) {
				$fkey = empty($sub_field['key']) ? $sub_field['name'] : $sub_field['key'];
				$sub_value = empty($row[$fkey]) ? null : $row[$fkey];
				$sub_field['name'] = $field['name'] . '_' . $i . '_' . $sub_field['name'];

				acf_update_value($sub_value, $post_id, $sub_field);
			}

			$i++;
		}

		$old_data = acf_get_value($post_id, $field, true);
		$old_data_size = count($old_data);
		if(count($value) < $old_data_size) {
			for($i=count($value); $i<$old_data_size; $i++) {
				$section = Blocks::get($old_data[$i]['id']);
				acf_delete_value($post_id, $field['name'] . '_' . $i . '_' . $sub_field['name']);
			}
		}

		return $data;
	}

	function load_value($value, $post_id, $field) {
		if(empty($value)) return $value;

		//$value = acf_force_type_array($value);

		$data = array();
		$i = 0;
		foreach($value as $v) {
			$id = $v['id'];
			$type = Blocks::get($id);
			if(empty($type)) continue;

			$sub_data = array(
				'acf_section' => $id,
				'acf_section_style_class' => empty($v['style_class']) ? '' : $v['style_class']);

			foreach($type->fields as $sub_field) {
				$name = $sub_field['name'];
				$sub_field['name'] = $field['name'] . '_' . $i . '_' . $name;
				$sub_value = acf_get_value($post_id, $sub_field);
				$sub_data[$name] = $sub_value;
			}

			$data[] = $sub_data;
			$i++;
		}

		return $data;
	}

	function format_value($value, $post_id, $field) {
		$result = array();
		foreach($value as $sub_value) {
			$type = Blocks::get($sub_value['acf_section']);

			$data = array(
				'acf_section' => $sub_value['acf_section'],
				'acf_section_style_class' => $sub_value['acf_section_style_class']
			);

			foreach($type->fields as $sub_field) {
				$name = $sub_field['name'];
				$data[$name] = acf_format_value($sub_value[$name], $post_id, $sub_field);
			}

			$result[] = $data;
		}
		return $result;
	}
}

new acf_field_sections();

class Block {
	function __construct() {
		// Define this section
		$fields = array();
		$this->define($fields);
		$this->fields = array();

		$this->register_fields($fields);

		Blocks::register($this);
	}

	private function register_fields($fields, $top = true) {
		foreach($fields as $k => $field) {
			$field = array_merge(array(
				'key' => '',
				'allow_null' => false,
				'multiple' => 0,
				'required' => 0
			), $field);

			if(! empty($field['key'])) {
				acf_local()->add_field($field);
			}

			if(! empty($field['sub_fields']) && is_array($field['sub_fields'])) {
				$this->register_fields($field['sub_fields'], false);
			}

			if($top) {
				$this->fields[$k] = $field;
			}
		}
	}

	function define(&$fields) {
	}

	function render($data, $styles) {
	}
}

class AbstractTextBlock extends Block {
	function __construct() {
		$this->id = 'text';
		$this->name = __('Text', 'ws-acf-sections');

		parent::__construct();
	}

	function define(&$fields) {
		parent::define($fields);

		$fields[] = array(
			'label' => __('Text', 'ws-acf-sections'),
			'name' => 'text',
			'type' => 'wysiwyg',
			'required' => 1
		);
	}
}

class LayoutBlock extends Block {
	function __construct() {
		parent::__construct();
	}

	function define(&$fields) {
		parent::define($fields);
	}

	function render_sections($sections, $styles) {
		echo '<div ';
		acf_esc_attr_e($styles);
		echo '>';
		Blocks::render($sections);
		echo '</div>';
	}

	function render_section($section, $attrs) {
		Blocks::render_single($section['acf_section'], $section, $attrs);
	}
}
