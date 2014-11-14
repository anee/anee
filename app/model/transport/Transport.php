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
	 * @ORM\ManyToOne(targetEntity="App\Model\User", inversedBy="transports")
	 */
	protected $user;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Track", mappedBy="transport", cascade={"remove"})
     */
    protected $tracks;

    public function __construct($name, $user)
    {
		$this->user = $user;
        $this->name = $name;
        $this->tracks = new ArrayCollection();
    }
}