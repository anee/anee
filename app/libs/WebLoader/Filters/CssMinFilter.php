<?php

namespace App\WebLoader\Filters;

use CssMin;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class CssMinFilter
{
	/**
	 * Minify target code
	 * @param string $code
	 * @return string
	 */
	public function __invoke($code)
	{
		return CssMin::minify($code, array("remove-last-semicolon"));
	}
}