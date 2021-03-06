--TEST--
Bug #64230 (XMLReader does not suppress errors)
--SKIPIF--
<?php
extension_loaded("xmlreader") or die("skip requires xmlreader");
?>
--FILE--
<?php
echo "Test\n";

function show_internal_errors() {
	foreach (libxml_get_errors() as $error) {
		printf("Internal: %s\n", $error->message);
	}
	libxml_clear_errors();
}

echo "Internal errors TRUE\n";
libxml_use_internal_errors(true);

$x = new XMLReader;
$x->xml("<root att/>");
$x->read();

show_internal_errors();

echo "Internal errors FALSE\n";
libxml_use_internal_errors(false);

$x = new XMLReader;
$x->xml("<root att/>");
$x->read();

show_internal_errors();

?>
Done
--EXPECTF--
Test
Internal errors TRUE
Internal: Specification mandate value for attribute att

Internal errors FALSE

Warning: XMLReader::read(): %s: parser error : Specification mandate value for attribute att in %s on line %d

Warning: XMLReader::read(): <root att/> in %s on line %d

Warning: XMLReader::read():          ^ in %s on line %d
Done
