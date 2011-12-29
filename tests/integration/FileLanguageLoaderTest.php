<?php

include_once(__DIR__.'/../../src/LanguageLoader.php');
include_once(__DIR__.'/../../src/FileLanguageLoader.php');

use \l10n\FileLanguageLoader;

/**
 * The data for these tests can be found in ../data/ 
 */
class FileLanguageLoaderIntegrationTest extends PHPUnit_Framework_TestCase {
	/**
	 * @test
	 */
	public function get_ExistingFile_TableIsLoadedCorrectly() {
		$loader = new FileLanguageLoader(__DIR__.'/../data');
		
		$result = $loader->get('file', 'a');
		
		$this->assertEquals('A', $result);
	}
}
?>