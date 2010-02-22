<?php

class Assets {
	static function img($name, $attributes = array())
	{
		$tag = '<img src="'. Assets::imgUrl($name) .'"';

		foreach ($attributes as $attr => $value) {
			$tag .= ' '.$attr .'="'. $value .'"';
		}

		// assert obligatory 'alt' attribute
		if (!in_array('alt', array_keys($attributes))) {
			$tag .= ' alt=""';
		}

		$tag .= '>';

		return $tag;
	}

	static function imgUrl($name) {
		return Config::get('web_path') . '/assets/images/'. $name .'.png';
	}
}
