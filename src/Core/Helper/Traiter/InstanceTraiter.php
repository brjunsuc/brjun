<?php


namespace W7engine\Core\Helper\Traiter;


trait InstanceTraiter {

	private static $instance;

	/**
	 * @return InstanceTraiter
	 */
	static public function instance() {
		if(!isset(self::$instance)){
			self::$instance = new static();
		}
		return self::$instance;
	}
}
