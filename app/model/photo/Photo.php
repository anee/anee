<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 */
class Photo extends BaseEntity
{

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\User", inversedBy="photos")
	 */
	protected $user;

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
     * @ORM\ManyToOne(targetEntity="App\Model\Track", inversedBy="photos")
     */
    protected $track;


    public function __construct($name, $path, $place)
    {
        $this->name = $name;
        $this->path = $path;
        $this->date = new DateTime;
        $this->place = $place;
    }
}