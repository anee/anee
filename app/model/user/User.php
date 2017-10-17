<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Nette\Security\Passwords;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;


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
	protected $usernameUrl;

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
	protected $lastLogin;

	/**
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	protected $lastVisitedHome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Role", inversedBy="user")
     */
	protected $role;

    /**
     * @param string $username
     * @param string $forename
     * @param string $surname
     * @param bool $public
     * @param string $email
     * @param string $password
     * @param Role $role
     */
	public function __construct($username, $forename, $surname, $public, $email, $password, Role $role)
	{
		$this->followers = new ArrayCollection();
		$this->following = new ArrayCollection();

		$this->forename = $forename;
		$this->surname = $surname;
		$this->username = $username;
		$this->usernameUrl = Strings::webalize($username);
		$this->email = $email;
		$this->public = $public;
		$this->password = Passwords::hash($password);
		$this->role = $role;

		$this->lastLogin = new DateTime();
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

    public function getUsername() {
        return $this->username;
	}

}