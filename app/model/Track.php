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
class Track extends \Kdyby\Doctrine\Entities\IdentifiedEntity
{

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


    public function __construct($transport, $distance, $timeInSeconds, $maxSpeed, $date, $place)
    {
        $this->transport = $transport;
        $this->distance = $distance;
        $this->timeInSeconds = $timeInSeconds;
        $this->maxSpeed = $maxSpeed;
        $this->date = $date;
        $this->place = $place;
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
        return round((($this->distance * 1000) / $this->timeInSeconds) * 3.6, 2);
    }
}