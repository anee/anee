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
class Place extends \Kdyby\Doctrine\Entities\IdentifiedEntity
{

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge(array('id' => $this->getId()), get_object_vars($this));
    }
}