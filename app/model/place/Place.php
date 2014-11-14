<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Nette\Utils\Strings;

/**
 * @ORM\Entity
 */
class Place extends BaseEntity
{

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\User", inversedBy="places")
	 */
	protected $user;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

	/**
	 * @ORM\Column(type="string", nullable=TRUE)
	 * @var string
	 */
	protected $nameUrl;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Track", mappedBy="place", cascade={"remove"})
     */
    protected $tracks;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Photo", mappedBy="place", cascade={"remove"})
     */
    protected $photos;


    public function __construct($name, $user)
    {
        $this->name = $name;
		$this->nameUrl = Strings::webalize($name);
		$this->user = $user;
        $this->tracks = new ArrayCollection();
		$this->photos = new ArrayCollection();
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
        if (count($this->tracks) > 0) {
            return round($this->getDistance() / count($this->tracks), 2);
        } else {
            return 0;
        }
    }

    public function getLastUpdate()
    {
        if(count($this->tracks) || count($this->photos)) {
            $dateTime = new DateTime();
            $count = 0;
            foreach($this->tracks as $track){
                if($count == 0 || $track->getDate() > $dateTime) {
                    $dateTime = $track->getDate();
                    $count++;
                }
            }
            foreach($this->photos as $photo){
                if($count == 0 || $photo->getDate() > $dateTime) {
                    $dateTime = $photo->getDate();
                    $count++;
                }
            }
            return $dateTime;
        } else {
            return NULL;
        }
    }

	public function getUrl()
	{
		return Strings::webalize($this->name);
	}

	public function setName($name)
	{
		$this->name = $name;
		$this->nameUrl = Strings::webalize($name);
	}
}