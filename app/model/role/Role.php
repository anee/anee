<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Role extends BaseEntity {

    const ADMIN = 'admin';
    const USER = 'user';

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 */
	protected $name;

	/**
	 * @param string $name
     */
	public function __construct($name)
	{
	    $this->name = $name;
	}

}