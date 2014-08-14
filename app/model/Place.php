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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Place extends \Kdyby\Doctrine\Entities\IdentifiedEntity
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

    public function __construct($name)
    {
        $this->name = $name;
        $this->tracks = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge(array('id' => $this->getId()), get_object_vars($this));
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
        return round($this->getDistance() / count($this->tracks), 2);
    }
}