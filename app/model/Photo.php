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
use DateTime;

/**
 * @ORM\Entity
 */
class Photo extends \Kdyby\Doctrine\Entities\IdentifiedEntity
{

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $fileName;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $filePath;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Place", inversedBy="photos")
     */
    protected $place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Event", inversedBy="photos")
     */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Track", inversedBy="photos")
     */
    protected $track;


    public function __construct($name, $path, $place, $eventFrom, $eventTo)
    {
        $this->name = $name;
        $this->path = $path;
        $this->date = new DateTime;
        $this->place = $place;
        $this->eventFrom = $eventFrom;
        $this->eventTo = $eventTo;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge(array('id' => $this->getId()), get_object_vars($this));
    }
}