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
use App\Utils\Arrays;



require __DIR__ . '/../bootstrap.php';


class ArraysTest extends Tester\TestCase
{

	function testTimeSubFilterTime()
	{
		$filterTime = 'Past hour';
		$time = new Nette\Utils\DateTime();
		$out = $time->sub(new \DateInterval('PT1H'));
		$time = Arrays::timeSubFilterTime($filterTime);
		Assert::Equal(true, $time->diff($out)->m < 2);

		$filterTime = 'Past week';
		$time = new Nette\Utils\DateTime();
		$out = $time->sub(new \DateInterval('P7D'));
		$time = Arrays::timeSubFilterTime($filterTime);
		Assert::Equal(true, $time->diff($out)->m < 2);

		$filterTime = 'Past month';
		$time = new Nette\Utils\DateTime();
		$out = $time->sub(new \DateInterval('P30D'));
		$time = Arrays::timeSubFilterTime($filterTime);
		Assert::Equal(true, $time->diff($out)->m < 2);

		$filterTime = 'Past year';
		$time = new Nette\Utils\DateTime();
		$out = $time->sub(new \DateInterval('P365D'));
		$time = Arrays::timeSubFilterTime($filterTime);
		Assert::Equal(true, $time->diff($out)->m < 2);
	}

	function testArrayContainsOrEmpty()
	{
		$array = array('0' => 'foo', '1' => 'bar');
		Assert::Equal(true, Arrays::arrayContainsOrEmpty('foo', $array));
		Assert::Equal(true, Arrays::arrayContainsOrEmpty('bar', $array));
		Assert::Equal(false, Arrays::arrayContainsOrEmpty('test', $array));

		$array = array();
		Assert::Equal(true, Arrays::arrayContainsOrEmpty('test', $array));
	}

	function testArrayContains()
	{
		$array = array('0' => 'foo', '1' => 'bar');
		Assert::Equal(true, Arrays::arrayContains('foo', $array));
		Assert::Equal(true, Arrays::arrayContains('bar', $array));
		Assert::Equal(false, Arrays::arrayContains('test', $array));
	}

	function testArrayContainsOnly()
	{
		$array = array('0' => 'foo');
		Assert::Equal(true, Arrays::arrayContainsOnly('foo', $array));
		Assert::Equal(false, Arrays::arrayContainsOnly('bar', $array));
		Assert::Equal(false, Arrays::arrayContainsOnly('test', $array));

		$array = array('0' => 'foo', '1' => 'bar');
		Assert::Equal(false, Arrays::arrayContainsOnly('foo', $array));
		Assert::Equal(false, Arrays::arrayContainsOnly('bar', $array));
		Assert::Equal(false, Arrays::arrayContainsOnly('test', $array));
	}
}

$test = new ArraysTest();
$test->run();
