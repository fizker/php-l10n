<?php
namespace l10n;

require_once(__DIR__.'/LanguageLoader.php');

class FileLanguageLoader extends LanguageLoader {
	private $dir;
	public function __construct($dir) {
		$this->dir = $dir;
	}
	
	public function loadTable($table) {
		$contents = file_get_contents($this->dir."/$table.strings");
		return $this->parse($contents);
	}
	
	public function stripComments($content) {
		$content = preg_replace(
			'!(//.*?)|(/\*(\s|.)*\*/)!U',
			'',
			$content
		);
		return $content;
	}
	
	public function parse($content) {
		$content = $this->stripComments($content);
		$lines = explode("\n", $content);
		$table = array();
		foreach($lines as $content) {
			$content = trim($content);
			if(!$content) {
				continue;
			}
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