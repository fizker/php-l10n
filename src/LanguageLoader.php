<?php 
namespace l10n;

abstract class LanguageLoader {
	private $data;
	
	protected abstract function loadTable($table);
	
	public function applyParams($str, $params) {
		if(sizeof($params) === 0)  {
			return $str;
		}
		if(strpos($str, '$&') !== false) {
			foreach($params as $param) {
				$str = preg_replace('/(\$&)/', $param, $str, 1);
			}
			$str = str_replace('$&', '', $str);
			return $str;
		}
		
		$str = preg_replace_callback('/\$(\d)/', function($matches) use ($params) {
			$index = $matches[1] - 1;
			if($index < sizeof($params)) {
				return $params[$index];
			}
			
			return '';
		}, $str);
		
		return $str;
	}
	
	public function get($table, $key, $params = array()) {
		if(!isset($this->data[$table])) {
			$this->data[$table] = $this->loadTable($table);
		}
		if(!isset($this->data[$table][$key])) {
			return $key;
		}
		
		$value = $this->data[$table][$key];
		
		if($params && !is_array($params)) {
			$params = func_num_args() > 2
				? array_slice(func_get_args(), 2)
				: array();
		}
		
		return $this->applyParams($value, $params);
	}
}
?>