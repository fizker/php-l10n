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

	/**
	 * @test
	 */
	public function get_MultipleParams_ParamsAreUsed() {
		$fakeLoader = new TestableLanguageLoader(array('a'=> 
			array('b'=> 'c $& d $& e')
		));
		
		$result = $fakeLoader->get('a', 'b', '1', 2);
		
		$this->assertEquals('c 1 d 2 e', $result);
	}

	/**
	 * @test
	 */
	public function get_ParamsAsArray_ParamsAreUsed() {
		$fakeLoader = new TestableLanguageLoader(array('a'=> 
			array('b'=> 'c $1 d $2 e')
		));
		
		$result = $fakeLoader->get('a', 'b', array('1', 2));
		
		$this->assertEquals('c 1 d 2 e', $result);
	}

	/**
	 * @test
	 */
	public function applyParams_NamedParams_TheRightParamsAreReplaced() {
		$loader = new TestableLanguageLoader(array());
		
		$result = $loader->applyParams('a $2 b $1 c', array(2, 1));
		
		$this->assertEquals('a 1 b 2 c', $result);
	}

	/**
	 * @test
	 */
	public function applyParams_MixedParamTypes_OnlyUnnamedAreUsed() {
		$loader = new TestableLanguageLoader(array());
		
		$result = $loader->applyParams('a $& b $1 c', array(2, 1));
		
		$this->assertEquals('a 2 b $1 c', $result);
	}

	/**
	 * @test
	 */
	public function applyParams_NamedParamsAreRepeated_ValueIsReused() {
		$loader = new TestableLanguageLoader(array());
		
		$result = $loader->applyParams('a $2 b $1 c $2', array(2, 1));
		
		$this->assertEquals('a 1 b 2 c 1', $result);
	}

	/**
	 * @test
	 */
	public function applyParams_NamedParamsExceedsList_BlankIsUsed() {
		$loader = new TestableLanguageLoader(array());
		
		$result = $loader->applyParams('a $2 b $1 c $2', array(1));
		
		$this->assertEquals('a  b 1 c ', $result);
	}

	/**
	 * @test
	 */
	public function applyParams_NamedParamsAreUnused_ValuesAreUnused() {
		$loader = new TestableLanguageLoader(array());
		
		$result = $loader->applyParams('a $2 b', array(2, 1));
		
		$this->assertEquals('a 1 b', $result);
	}

	/**
	 * @test
	 */
	public function applyParams_UnnamedParamsAreRepeated_RestAreBlank() {
		$loader = new TestableLanguageLoader(array());
		
		$result = $loader->applyParams('a $& b $& c', array(2));
		
		$this->assertEquals('a 2 b  c', $result);
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