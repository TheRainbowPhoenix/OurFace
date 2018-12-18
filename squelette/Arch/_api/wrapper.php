<?php
class wrapper
{
  private $data;
	private static $instance=null;

  public static function getInstance() {
		if(self::$instance==null)
		  self::$instance=new wrapper();
		return self::$instance;
	}

  private function __construct() {

	}

  public function __get($prop) {
      return $this->data[$prop];
  }

  public function __set($prop,$value) {
      $this->data[$prop]=$value;
  }

  public function parse($func, $params) {
	  if(method_exists('parser',$func)) {

	header('Content-Type: application/json;charset=utf-8');
	return parser::$func($params);
	  } else return false;

  }

  public static function post() {
    return "post";
  }
}
