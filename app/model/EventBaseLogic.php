<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventBaseLogic extends Nette\Object {

    private $events;

    public function __construct(EntityDao $dao)
    {
        $this->events = $dao;
    }

    public function save($event)
    {
        $this->events->save($event);
    }

    public function remove($id)
    {
        $this->events->delete($this->findById($id));
    }

    public function findAll()
    {
        $qb = $this->events->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findAllCount()
    {
        $qb = $this->events->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Event', 'e');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findLast()
    {
        $qb = $this->events->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    public function findById($id)
    {
        $qb = $this->events->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
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