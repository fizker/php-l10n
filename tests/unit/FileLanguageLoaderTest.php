<?php

include_once(__DIR__.'/../../src/LanguageLoader.php');
include_once(__DIR__.'/../../src/FileLanguageLoader.php');

use \l10n\FileLanguageLoader;

class FileLanguageLoaderTest extends PHPUnit_Framework_TestCase {
	/**
	 * @test
	 */
	public function parse_SingleLine_TableIsReturned() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->parse('"a"="b";');
		
		$this->assertEquals(array(
			'a'=> 'b'
		), $result);
	}
	
	/**
	 * @test
	 */
	public function parse_MultipleLines_TableIsReturned() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->parse(
'"a" = "1";
"b" ="2"
"c"= "3";'
		);
		
		$this->assertEquals(array(
			'a'=> '1',
			'b'=> '2',
			'c'=> '3',
		), $result);
	}
}
?>