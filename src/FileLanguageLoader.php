<?php
namespace l10n;

class FileLanguageLoader extends LanguageLoader {
	private $dir;
	public function __construct($dir) {
		$this->dir = $dir;
	}
	
	public function loadTable($table) {
		$contents = file_get_contents($this->dir."/$table.l10n");
	}
	
	public function parse($content) {
		$lines = explode("\n", $content);
		$table = array();
		foreach($lines as $content) {
			$split = explode('=', $content);
			$table[$this->trim($split[0])] = $this->trim($split[1]);
		}
		return $table;
	}
	
	private function trim($str) {
		return trim($str, ' ";');
	}
}
?>