<?php

class TwigBlock extends Block {
	function __construct() {
		parent::__construct();
	}

	function render($data, $styles) {
		$data = $this->get_template_data($data);
		$data['class'] = $styles['class'];

		unset($styles['class']);
		$data['extra_attrs'] = acf_esc_attr($styles);

		echo Twig_Renderer::$twig->render('blocks/' . $this->id . '.twig', $data);
	}

	function get_template_data($data) {
		return $data;
	}
}
