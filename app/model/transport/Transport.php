<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * @ORM\Entity
 */
class Transport extends BaseEntity
{

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Track", mappedBy="transport")
     */
    protected $tracks;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Event", mappedBy="transport")
     */
    protected $events;


    public function __construct($name)
    {
        $this->name = $name;
        $this->tracks = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getCount()
    {
        return count($this->tracks) + count($this->events);
    }
}