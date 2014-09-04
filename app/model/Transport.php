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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Transport extends \Kdyby\Doctrine\Entities\IdentifiedEntity
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

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge(array('id' => $this->getId()), get_object_vars($this));
    }

    public function getCount()
    {
        return count($this->tracks) + count($this->events);
    }
}