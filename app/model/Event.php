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
     * @ORM\Column(type="string", nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $from;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $to;

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
    protected $timeInSecondsTrip;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $date;

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
        if ($this->getFrom() == $this->getTo())
            return 'Near '.$this->getFrom();
        else
            return 'From '.$this->getFrom() .' to ' . $this->getTo();
    }

    public function getAvgSpeed()
    {
        return ($this->getDistance()/($this->getTimeInSecondsTrip()/(60*60*24)));
    }
}