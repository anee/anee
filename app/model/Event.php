<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 1.3.14
 * Time: 18:02
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;

/**
 * @ORM\Entity
 */
class Event extends \Kdyby\Doctrine\Entities\IdentifiedEntity
{

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=false)
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

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge(array('id' => $this->getId()), get_object_vars($this));
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
        return round(($this->getDistance()/($this->getTimeInSeconds()/(60*60*24))), 0);
    }

    public function getLastPhoto()
    {
        return $this->eventPhotos->last();
    }
}