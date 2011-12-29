<?php 
namespace l10n;

abstract class LanguageLoader {
	private $data;
	
	protected abstract function loadTable($table);
	
	public function get($table, $key) {
		if(!isset($this->data[$table])) {
			$this->data[$table] = $this->loadTable($table);
		}
		if(isset($this->data[$table][$key])) {
			return $this->data[$table][$key];
		}
		return $key;
	}
}
?>