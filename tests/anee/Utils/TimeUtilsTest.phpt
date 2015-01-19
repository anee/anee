<?php

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 *
 * @testCase
 */

namespace App\Tests\Utils;


use Nette;
use	Tester;
use	Tester\Assert;
use App\Utils\TimeUtils;



require __DIR__ . '/../bootstrap.php';


class TimeUtilsTest extends Tester\TestCase
{
	function testFromSecondsHours() {
		$out = TimeUtils::fromSecondsHours(3600);
		Assert::equal(1.0, $out);
	}

	function testFromSecondsMinutes() {
		$out = TimeUtils::fromSecondsMinutes(60);
		Assert::equal(1.0, $out);
	}

	function testFromSecondsSeconds() {
		$out = TimeUtils::fromSecondsSeconds(61);
		Assert::equal(1, $out);
	}

	function testFromSpanToSeconds()
	{
		$out = TimeUtils::fromSpanToSeconds(1, 1, 1);
		Assert::equal(3661, $out);
	}
}

$test = new TimeUtilsTest();
$test->run();
