<?php

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
 "b" ="2"; 
"c"= "3";'
		);
		
		$this->assertEquals(array(
			'a'=> '1',
			'b'=> '2',
			'c'=> '3',
		), $result);
	}

	/**
	 * @test
	 */
	public function parse_EmptyLines_TableIsReturned() {
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

	/**
	 * @test
	 */
	public function parse_LineWithOnlyComment_TableIsReturned() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->parse(
'"a" = "1";
// some comment
"b" ="2"
 // some comment
"c"= "3";'
		);
		
		$this->assertEquals(array(
			'a'=> '1',
			'b'=> '2',
			'c'=> '3',
		), $result);
	}

	/**
	 * @test
	 */
	public function stripComments_LineWithOnlyComments_CommentIsGone() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->stripComments(
			'// comment
			"a"="b";'
		);
		
		$this->assertEquals(
			'
			"a"="b";'
			, $result);
	}

	/**
	 * @test
	 */
	public function stripComments_SingleLineCommentAtEnd_CommentIsGone() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->stripComments('"a"="b"; // some comment');
		
		$this->assertEquals('"a"="b"; ', $result);
	}

	/**
	 * @test
	 */
	public function stripComments_SingleLineBlockComment_CommentIsGone() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->stripComments('/* some comment */
			"a"="b";');
		
		$this->assertEquals('
			"a"="b";', $result);
	}

	/**
	 * @test
	 */
	public function stripComments_MultiLineBlockComment_CommentIsGone() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->stripComments('/* some 
		comment */
			"a"="b";');
		
		$this->assertEquals('
			"a"="b";', $result);
	}

	/**
	 * @test
	 */
	public function stripComments_MultipleBlockComments_OnlyCommentsAreGone() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->stripComments('/* some 
		comment */
			"a"="b";
			/**/');
		
		$this->assertEquals('
			"a"="b";
			', $result);
	}

	/**
	 * @test
	 */
	public function parse_BlockComment_TableIsReturned() {
		$loader = new FileLanguageLoader('');
		
		$result = $loader->parse(
'"a" = "1";
/* some comment block */
"b" ="2";
 /* a 
 multiline
 comment
 block*/
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