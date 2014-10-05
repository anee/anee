<?php

namespace App\Model;

use Nette\Security\Passwords;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class User extends BaseEntity {

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $password;

	/**
	 * @param $username
	 * @param $email
	 * @param $password
	 */
	public function __construct($username, $email, $password)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = Passwords::hash($password);
	}

} 