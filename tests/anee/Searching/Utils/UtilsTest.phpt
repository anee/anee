<?php

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 *
 * @testCase
 */

namespace App\Tests\Searching\Utils;


use App\Searching\Utils;
use Nette;
use	Tester;
use	Tester\Assert;



require __DIR__ . '/../../bootstrap.php';


class UtilsTest extends Tester\TestCase
{

	private $clear = array(
		'search' => '',
		'userId' => '',
		'username' => '',
		'usernameUrl' => '',
		'filterCategory' => array(),
		'filterTransport' => array(),
		'filterTimeStart' => '',
		'filterTimeEnd' => '',
		'filterSortBy' => '',
		'filterEntity' => '',
		'filterEntityId' => ''
	);

	function testCheckValuesArray()
	{
		$array = NULL;
		$out = Utils::checkValuesArray($array);
		Assert::Equal($this->clear, $out);


		$array = array(
			'search' => '',
			'userId' => '',
			'username' => '',
			'usernameUrl' => '',
			'filterCategory' => array(),
			'filterTransport' => array(),
		);
		$out = Utils::checkValuesArray($array);
		Assert::Equal($this->clear, $out);


		$array = array(
			'search' => '',
			'userId' => '',
			'username' => '',
		);

		$out = Utils::checkValuesArray($array);
		Assert::Equal($this->clear, $out);
	}

	function testClearValuesArray()
	{
		$out = Utils::clearValuesArray();
		Assert::Equal($this->clear, $out);
	}
}

$test = new UtilsTest();
$test->run();
