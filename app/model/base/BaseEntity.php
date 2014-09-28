<?php


namespace App\Model;

use Kdyby\Doctrine\Entities\IdentifiedEntity;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class BaseEntity extends IdentifiedEntity {


	/**
	 * @return array
	 */
	public function toArray()
	{
		return array_merge(array('id' => $this->getId()), get_object_vars($this));
	}
} 