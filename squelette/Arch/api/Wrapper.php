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
    return ((method_exists('parser',$func))?(parser::$func($params)):(false));

  }

  public static function post() {
    echo "POST";
    return "post";
  }
}
