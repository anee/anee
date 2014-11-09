<?php

namespace App\Model;

use Nette\Security\Passwords;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;


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
	 * @ORM\ManyToMany(targetEntity="App\Model\User", mappedBy="following", cascade={"remove"})
	 */
	protected $followers;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Model\User", inversedBy="followers", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="user_user",
	 *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
	 *      )
	 */
	protected $following;

	/**
	 * @ORM\Column(type="string", nullable=TRUE)
	 * @var string
	 */
	protected $profileImage;

	/**
	 * @ORM\Column(type="string", nullable=TRUE)
	 * @var string
	 */
	protected $backgroundImage;

	/**
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	protected $lastLogged;

	/**
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	protected $lastVisitedHome;

	/**
	 * @param $username
	 * @param $public
	 * @param $email
	 * @param $password
	 */
	public function __construct($username, $forename, $surname, $public, $email, $password)
	{
		$this->followers = new \Doctrine\Common\Collections\ArrayCollection();
		$this->following = new \Doctrine\Common\Collections\ArrayCollection();

		$this->forename = $forename;
		$this->surname = $surname;
		$this->username = $username;
		$this->email = $email;
		$this->public = $public;
		$this->password = Passwords::hash($password);
		$this->lastLogin = new DateTime();
	}

	public function getTotalDistance()
	{
		$distance = 0;
		foreach($this->tracks as $track) {
			$distance += $track->distance;
		}
		return round($distance);
	}

	public function getName()
	{
		if($this->forename != "" && $this->surname != "") {
			return $this->forename . ' ' . $this->surname;
		} elseif($this->forename != "") {
			return $this->forename;
		} else {
			return $this->username;
		}
	}

	public function getFollowing()
	{
		return $this->following;
	}
	public function getFollowers()
	{
		return $this->followers;
	}

	public function removeFollowing(User $user)
	{
		$this->following->removeElement($user);
	}

	public function removeFollower(User $user)
	{
		$this->followers->removeElement($user);
		$user->removeFollowing($this);
	}

	public function setLastLogin($lastLogin) {
		$this->lastLogin = $lastLogin;
	}

	public function getLastLogin() {
		return $this->lastLogin;
	}

	public function setLastVisitedHome($datetime) {
		$this->lastVisitedHome = $datetime;
	}

	public function getLastVisitedHome() {
		return $this->lastVisitedHome;
	}
}