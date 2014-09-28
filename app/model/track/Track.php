<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 */
class Track extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Transport", inversedBy="track")
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
     * @ORM\Column(type="float", nullable=false)
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
     * @ORM\OneToMany(targetEntity="App\Model\Photo", mappedBy="track")
     */
    protected $photos;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $fileName;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $filePath;


    public function __construct($transport, $distance, $timeInSeconds, $maxSpeed, $date, $place)
    {
        $this->transport = $transport;
        $this->distance = $distance;
        $this->timeInSeconds = $timeInSeconds;
        $this->maxSpeed = $maxSpeed;
        $this->date = $date;
        $this->place = $place;
    }

    public function getName()
    {
        if ($this->placeTo == NULL || $this->place->getName() == $this->placeTo->getName())
            return 'Near '.$this->place->getName();
        else
            return 'From '.$this->place->getName() .' to ' . $this->placeTo->getName();
    }

    public function getAvgSpeed()
    {
        return round((($this->distance * 1000) / $this->timeInSeconds) * 3.6, 2);
    }
}