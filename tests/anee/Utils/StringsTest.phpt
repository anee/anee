<?php

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 *
 * @testCase
 */

namespace App\Tests\Utils;


use App\Utils\Strings;
use Nette;
use	Tester;
use	Tester\Assert;



require __DIR__ . '/../bootstrap.php';


class StringsTest extends Tester\TestCase
{
	function testStrafter()
	{
		$string = "Hello bar foo";
		$substring = "Hello";
		$out = Strings::strafter($string, $substring);
		Assert::Equal(' bar foo', $out);
	}

	function testStrbefore()
	{
		$string = "Hello bar foo";
		$substring = "bar";
		$out = Strings::strbefore($string, $substring);
		Assert::Equal('Hello ', $out);
	}
}

$test = new StringsTest();
$test->run();
