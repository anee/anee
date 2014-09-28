<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Place extends BaseEntity
{

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Track", mappedBy="place")
     */
    protected $tracks;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Event", mappedBy="place")
     */
    protected $events;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Photo", mappedBy="place")
     */
    protected $photos;

    public function __construct($name)
    {
        $this->name = $name;
        $this->tracks = new ArrayCollection();
    }

    public function getDistance()
    {
        $distance = 0;
        foreach ($this->tracks as $track) {
            $distance += $track->distance;
        }
        return $distance;
    }

    public function getTimeInSeconds()
    {
        $time = 0;
        foreach ($this->tracks as $track) {
            $time += $track->getTimeInSeconds();
        }
        return $time;
    }

    public function getAvgDistance()
    {
        if (count($this->tracks) > 0) {
            return round($this->getDistance() / count($this->tracks), 2);
        } else {
            return 0;
        }
    }

    public function getLastUpdate()
    {
        if(count($this->events) > 0 || count($this->tracks) || count($this->photos)) {
            $dateTime = new DateTime();
            $count = 0;
            foreach($this->events as $event){
                if($count == 0 || $event->getDate() > $dateTime) {
                    $dateTime = $event->getDate();
                    $count++;
                }
            }
            foreach($this->tracks as $track){
                if($count == 0 || $track->getDate() > $dateTime) {
                    $dateTime = $track->getDate();
                    $count++;
                }
            }
            foreach($this->photos as $photo){
                if($count == 0 || $photo->getDate() > $dateTime) {
                    $dateTime = $photo->getDate();
                    $count++;
                }
            }
            return $dateTime;
        } else {
            return NULL;
        }
    }
}