<?php


namespace W7\Engine\Core\Helper\Traiter;


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
