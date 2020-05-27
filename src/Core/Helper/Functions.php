<?php

namespace W7\Engine\Core\Helper;

if (!function_exists('iconfig')) {

	function iconfig() {
		return array(1,23,34);
//		return App::getApp()->getConfigger();
	}
}