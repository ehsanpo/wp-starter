<?php
new \Timber\Timber();
new Timmy\Timmy();
class SitePost extends TimberPost {
	public function menu_parent() {
		if($this->parent !== false) {
			$parent = $this->parent;

			if($parent->parent !== false) {
				return $parent->parent;
			}

			return $parent;
		}

		return $this;
	}

	/**
	 * Get if this post is in the current page hierarchy.
	 */
	public function in_hierarchy(TimberPost $post) {
		while ($post) {
			if ($post->id === $this->id) {
				return true;
			}
			$post = $post->parent;
		}
		return false;
	}

	private function _parents() {
		$result = array();
		if($this->parent !== false) {
			$parent = $this->parent;
			$result[] = $parent;

			if($parent->parent !== false) {
				$parent = $parent->parent;
				$result[] = $parent;

				if($parent->parent !== false) {
					$parent = $parent->parent;
					$result[] = $parent;
				} else {
					$result[]  = $this;
				}
			} else {
				$result[] = $this;
			}
		} else {
			$result[] = $this;
		}

		return $result;
	}

	public function primary_nav_parent() {
		$parents = $this->_parents();
		return $parents[0];
	}

	public function secondary_nav_parent() {
		$parents = $this->_parents();
		return empty($parents[1]) ? false : $parents[1];
	}

	public function third_nav_parent() {
		$parents = $this->_parents();
		return empty($parents[2]) ? false : $parents[2];
	}
}
