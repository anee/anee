<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 */
class Track extends BaseEntity
{

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\User", inversedBy="tracks")
	 */
	protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Transport", inversedBy="tracks")
     */
    protected $transport;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $distance;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $timeInSeconds;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $maxSpeed;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Place", inversedBy="tracks")
     */
    protected $place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Place", inversedBy="tracks")
     */
    protected $placeTo;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Photo", mappedBy="track", cascade={"persist", "remove"})
     */
    protected $photos;

	/**
	 * @ORM\Column(type="boolean", nullable=TRUE)
	 */
	protected $pinned;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Model\User", cascade={"persist"})
	 * @ORM\JoinTable(name="track_user",
	 *        joinColumns={@ORM\JoinColumn(name="track_id", referencedColumnName="id")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
	 *    )
	 * @var []|\Doctrine\Common\Collections\ArrayCollection
	 */
	protected $withUsers;


    public function __construct($user, $transport, $distance, $timeInSeconds, $place, $date, $pinned, $placeTo = NULL, $maxSpeed = NULL)
    {
		$this->withUsers = new \Doctrine\Common\Collections\ArrayCollection();

		$this->pinned = $pinned;
		$this->user = $user;
        $this->transport = $transport;
        $this->distance = $distance;
        $this->timeInSeconds = $timeInSeconds;
		$this->maxSpeed = $maxSpeed;
        $this->date = $date;
        $this->place = $place;
        $this->placeTo = $placeTo;
    }

    public function getName()
    {
		if($this->place == NULL) {
			return 'Unknown track';
		} elseif($this->placeTo == NULL || $this->place->getName() == $this->placeTo->getName())
            return 'Near '.$this->place->getName();
        else
            return 'From '.$this->place->getName() .' to ' . $this->placeTo->getName();
    }

    public function getAvgSpeed()
    {
		if($this->distance == 0 || $this->timeInSeconds == 0) {
			return 0;
		} else {
			return round((($this->distance * 1000) / $this->timeInSeconds) * 3.6, 2);
		}
    }

	public function getWithUsers()
	{
		return $this->withUsers;
	}

    /**
     * @return \App\Model\User
     */
    public function getUser()
    {
        return $this->user;
	}

    /**
     * @return bool
     */
    public function isPinned()
    {
        return $this->pinned;
	}

    public function getDistance()
    {
        return $this->distance;
	}

    /**
     * @return float
     */
    public function getTimeInSeconds()
    {
        return $this->timeInSeconds;
    }
}