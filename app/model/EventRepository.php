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
use App\Utils\FilterUtils;

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
            ->orderBy('e.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findLast()
    {
        $qb = $this->events->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e')
            ->orderBy('e.id', 'DESC');

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

        return $qb->getQuery()->getSingleResult();
    }

    public function distanceSum()
    {
        $distance = 0;
        foreach ($this->findAll() as $event) {
            $distance += $event->getDistance();
        }
        return $distance;
    }

    public function findByFilters($values)
    {
        $qb = $this->events->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e');

        if($values['search'] != '') {
            $qb
                ->join('e.place', 'a')
                ->leftJoin('e.placeTo', 'b')
                ->where('b IS NOT NULL')
                ->where($qb->expr()->like('a.name', ':search'))
                ->orWhere($qb->expr()->like('b.name', ':search'))
                ->orWhere($qb->expr()->like('e.description', ':search'))
                ->setParameter('search', '%' . $values['search'] . '%');
        }
        if($values['filterTime'] != '') {
            $qb
                ->andWhere('e.date >= :date')
                ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
        }
        if($values['filterTransport'] != '') {
            $qb
                ->andWhere('e.transport >= :transport')
                ->setParameter('transport', $values['filterTransport']);
        }
        $qb
            ->orderBy('e.id', 'DESC');


        return $qb->getQuery()->getResult();
    }
}