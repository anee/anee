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


    public function __construct($user, $fileName, $filePath, $date = NULL, $place = NULL, $track = NULL)
    {
		$this->user = $user;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->place = $place;
		$this->track = $track;
		if($date == NULL) {
			$this->date = new DateTime;
		} else {
			$this->date = $date;
		}
    }
}