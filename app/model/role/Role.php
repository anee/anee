<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\OneToMany(targetEntity="App\Model\User", mappedBy="role", cascade={"persist", "remove"})
     */
    protected $users;

	/**
	 * @param string $name
     */
	public function __construct($name)
	{
	    $this->name = $name;

        $this->users = new ArrayCollection();
	}

    public function getName() {
        return $this->name;
	}

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
	}

    public function getUsers() {
        return $this->users;
	}

    public function isDefaultOne() {
        return $this->name == self::ADMIN || $this->name == self::USER;
	}

}
