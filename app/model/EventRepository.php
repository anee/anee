<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 8.4.14
 * Time: 0:28
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;

class EventRepository extends Nette\Object {

    private $events;

    public function __construct(EntityDao $dao)
    {
        $this->events = $dao;
    }

    public function save($event)
    {
        $this->events->save($event);
    }

    public function findAll()
    {
        return $this->events->findBy(array(), array('id' => 'DESC'));
    }

    public function findLast()
    {
        return $this->events->findOneBy(array(), array('id' => 'DESC'), 1);
    }

    public function findById($id)
    {
        return $this->events->find($id);
    }

    public function remove($id)
    {
        $this->events->delete($this->findById($id));
    }

    public function distanceSum()
    {
        $distance = 0;
        foreach ($this->findAll() as $event) {
            $distance += $event->getDistance();
        }
        return $distance;
    }
}