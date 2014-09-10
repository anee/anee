<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\FilterUtils;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
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

    public function findByFilters($values)
    {
        if(FilterUtils::arrayContainsOrEmpty('Events', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->events->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Event', 'e');

            if($values['filterEntity'] == 'Place') {
                $qb
                    ->leftJoin('e.place', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
            }
            $qb
                ->orderBy('e.date', 'DESC');
            return $qb->getQuery()->getResult();

        } elseif(FilterUtils::arrayContainsOrEmpty('Events', $values['filterCategory']) == true) {
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
            if(empty($values['filterTransport']) != true) {
                $qb
                    ->join('e.transport', 'c')
                    ->andWhere('c.name IN (:transports)')
                    ->setParameter('transports', $values['filterTransport']);
            }
            $qb
                ->orderBy('e.date', 'DESC');
            return $qb->getQuery()->getResult();

        } else {
            return array();
        }
    }

    public function findByFiltersCount($values) {
        if($values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->events->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Event', 'e');
            if($values['filterEntity'] == 'Place') {
                $qb
                    ->leftJoin('e.place', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
            }
            return $qb->getQuery()->getSingleScalarResult();

        } else {
            $qb = $this->events->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
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
            if(empty($values['filterTransport']) != true) {
                $qb
                    ->join('e.transport', 'c')
                    ->andWhere('c.name IN (:transports)')
                    ->setParameter('transports', $values['filterTransport']);
            }
            return $qb->getQuery()->getSingleScalarResult();
        }
    }
}