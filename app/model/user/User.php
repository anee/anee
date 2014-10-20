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
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	protected $forename;

	/**
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	protected $surname;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $public;

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $password;

	/**
	 * @ORM\OneToMany(targetEntity="App\Model\Track", mappedBy="user")
	 */
	protected $tracks;

	/**
	 * @ORM\OneToMany(targetEntity="App\Model\Place", mappedBy="user")
	 */
	protected $places;

	/**
	 * @ORM\OneToMany(targetEntity="App\Model\Transport", mappedBy="user")
	 */
	protected $transports;

	/**
	 * @ORM\OneToMany(targetEntity="App\Model\Photo", mappedBy="user")
	 */
	protected $photos;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Model\User", inversedBy="user", cascade={"persist"})
	 */
	protected $followingUsers;

	/**
	 * @param $username
	 * @param $public
	 * @param $email
	 * @param $password
	 */
	public function __construct($username, $forename, $surname, $public, $email, $password)
	{
		$this->forename = $forename;
		$this->surname = $surname;
		$this->username = $username;
		$this->email = $email;
		$this->public = $public;
		$this->password = Passwords::hash($password);
	}

	public function getTotalDistance()
	{
		$distance = 0;
		foreach($this->tracks as $track) {
			$distance += $track->distance;
		}
		return $distance;
	}

	public function getName()
	{
		return $this->forename.' '.$this->surname;
	}
}