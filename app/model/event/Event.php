<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 */
class Event extends BaseEntity
{

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\User", inversedBy="events")
	 */
	protected $user;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Transport", inversedBy="events")
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
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Place", inversedBy="events")
     */
    protected $place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Place", inversedBy="events")
     */
    protected $placeTo;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Photo", mappedBy="event")
     */
    protected $eventPhotos;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Photo", inversedBy="event")
     */
    protected $photo;


    public function __construct($distance, $timeInSeconds, $date)
    {
        $this->distance = $distance;
        $this->timeInSeconds = $timeInSeconds;
        $this->date = $date;
    }

    public function getName()
    {
		if($this->place == NULL) {
			return 'Unknown event';
		} elseif($this->placeTo == NULL || $this->place->getName() == $this->placeTo->getName())
            return 'Near '.$this->place->getName();
        else
            return 'From '.$this->place->getName() .' to ' . $this->placeTo->getName();
    }

    public function getAvgSpeed()
    {
        return round(($this->getDistance()/($this->getTimeInSeconds()/(60*60*24))), 0);
    }

    public function getLastPhoto()
    {
        return $this->eventPhotos->last();
    }
}