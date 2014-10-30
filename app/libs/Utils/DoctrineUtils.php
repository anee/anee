<?php


namespace App\Utils;

use Doctrine\Common\Collections;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class DoctrineUtils {

	public static function toDoctrineArray($result)
	{
		return new Collections\ArrayCollection($result);
	}
} 