<?php


namespace App\WebLoader;

use JShrink\Minifier;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */

class JsMinFilter
{
	/**
	 * Minify target code
	 * @param string $code
	 * @return string
	 */
	public function __invoke($code)
	{
		return Minifier::minify($code);
	}
}