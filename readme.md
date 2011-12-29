Language Loader
===============

The purpose of this project is to deliver a simple, lazy-loading language 
loader, which helps make localized php apps.

It is designed to be data-source agnostic, but a file-system based 
implementation will be included.

All that is required of a sub-implementation is to override the loadTable
function, which will be called the first time a specific table is requested.


Working with the FileLanguageLoader
-----------------------------------

To see a live version, check the tests/integration folder, where it is used
in some integration tests.

The following code snippet shows how to use the code:

	<?php
	include(__DIR__.'/lib/dir/php-l10n/index.php');
	
	$lang = new \l10n\FileLanguageLoader(__DIR__.'/lang/pak/dir');
	
	print $lang->get('table', 'key');
	?>

This will load the file `table.strings` from inside the `{root}/lang/pak/dir`
folder, and return the value for the key `key`.

The folder containing the language files should be a flat directory, where
each file has the extension `.strings` and is named after the table wanted.

The file contents should follow the same syntax that 
[Apple uses in Cocoa](http://developer.apple.com/library/mac/#documentation/Cocoa/Reference/Foundation/Miscellaneous/Foundation_Functions/Reference/reference.html#//apple_ref/c/macro/NSLocalizedStringFromTable).
__NOTE: There is one exception: This library does not currently support comments!__

Such a file might look like this:

	"key" = "value";
	"another key" = "another value";