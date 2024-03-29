<?php

/**
 * php-excel
 * 
 * The MIT License
 * Copyright (c) 2007 Oliver Schwarz
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

// include the php-excel class
require (dirname (__FILE__) . "/class-excel-xml.inc.php");

// create a dummy array
/*$doc = array (
    1 => array ("Oliver", "Peter", "Paul"),
         array ("Marlene", "Lucy", "Lina"),
		 array ("12", "012", "000"),
		 array ("12", "012", "000")
    );*/
	
	$doc[1][0] = "Oliver";
	$doc[1][1] = "Peter";
	$doc[1][2] = "Paul";
	
	$doc[2][0] = "14";
	$doc[2][1] = "05";
	$doc[2][2] = "00";
	
	$doc[3][0] = "14";
	$doc[3][1] = "05";
	$doc[3][2] = "00";
	
	
// generate excel file
$xls = new Excel_XML;
$xls->addArray ( $doc );
$xls->generateXML ("mytest");

?>