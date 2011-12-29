<?php

include_once(__DIR__.'/../../src/LanguageLoader.php');

use \l10n\LanguageLoader;

class LanguageLoaderTest extends PHPUnit_Framework_TestCase {
	/**
	 * @test
	 * @dataProvider provider_get_NoMatchingValue_KeyIsReturned
	 */
	public function get_NoMatchingValue_KeyIsReturned($key) {
		$l10n = new TestableLanguageLoader(array( 'table'=> array() ));
		
		$result = $l10n->get('table', $key);
		
		$this->assertEquals($key, $result);
	}
	public function provider_get_NoMatchingValue_KeyIsReturned() {
		return array(
			array('a'),
			array('b')
		);
	}
	
	/**
	 * @test
	 */
	public function get_KeyExists_ValueIsReturned() {
		$l10n = new TestableLanguageLoader(array(
			'table'=> array(
				'a'=> 'b'
			)
		));
		
		$result = $l10n->get('table', 'a');
		
		$this->assertEquals('b', $result);
	}

	/**
	 * @test
	 */
	public function get_ValueIsAskedFor_TableIsLazyLoaded() {
		$fakeLoader = $this->getMockForAbstractClass('\l10n\LanguageLoader');
		
		$fakeLoader
			->expects($this->once())
			->method('loadTable')
			->will($this->returnValue(array()));
		
		$fakeLoader->get('a', 'b');
	}
}

class TestableLanguageLoader extends LanguageLoader {
	private $data;
	public function __construct($data) {
		$this->data = $data;
	}
	
	public function loadTable($table) {
		return $this->data[$table];
	}
}
?>