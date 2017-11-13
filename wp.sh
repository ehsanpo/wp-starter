#!/bin/bash
mypwd="$PWD"

if [ ! -d "$mypwd/web" ]; then
	echo "Wrong folder!"
 	exit
fi

if [ $# -eq 0 ]; then
    echo "No arguments provided"
    exit 1
fi


if [  -f "$mypwd/web/theme/blocks/$1.php" ] || [ -f "$mypwd/web/theme/blocks/$1-block.php" ]  ; then
  echo "Block finns"
  exit 1
fi

PHPHFILE='<?php
class '${1}'Block extends TwigBlock {
	function __construct() {
		$this->id = "'${1}'-block";
		$this->name = "'${1}' Block";

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(

		);
		
	}

	function get_template_data($data) {
		return $data;
	}
}

new '${1}'Block();
'

echo "$PHPHFILE" >> "$mypwd/web/theme/blocks/$1-block.php"
echo 'PHP file created.'

echo '<div class="'${1}'-block"> 

</div>' >> "$mypwd/web/theme/views/blocks/$1-block.twig"

echo 'Twig file created.'

echo '.'${1}'-block{

}' >> "$mypwd/web/theme/assets/sass/blocks/$1-block.scss"

echo '@import "blocks/'${1}'-block.scss";' >> "$mypwd/gg/assets/sass/main.scss"
echo 'CSS file created.'