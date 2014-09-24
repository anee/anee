<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoSearchLogic extends  Nette\Object {

    private $photos;

    public function __construct(EntityDao $dao)
    {
        $this->photos = $dao;
    }

    public function findByFilters($values)
    {
        if(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->photos->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Photo', 'e');
            if($values['filterEntity'] == 'Event') {
                $qb
                    ->leftJoin('e.event', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            } elseif($values['filterEntity'] == 'Track') {
                $qb
                    ->leftJoin('e.track', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            } elseif($values['filterEntity'] == 'Place') {
                $qb
                    ->leftJoin('e.place', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
            }
			if ($values['filterSortBy'] == '') {
				$qb
					->orderBy('e.date', 'DESC');
			}
            return $qb->getQuery()->getResult();
        } elseif(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true) {
            $qb = $this->photos->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Photo', 'e');

            if($values['search'] != '') {
                $qb
                    //track
                    ->leftJoin('e.track', 'b')
                    ->where('b IS NOT NULL')
                    ->leftJoin('b.place', 'g')
                    ->leftJoin('b.placeTo','h')
                    ->where('h IS NOT NULL')
                    //event
                    ->leftJoin('e.event', 'o')
                    ->where('o IS NOT NULL')
                    ->leftJoin('o.place', 'p')
                    ->leftJoin('o.placeTo','q')
                    ->where('q IS NOT NULL')
                    //place
                    ->leftJoin('e.place', 'a')
                    ->where('a IS NOT NULL')
                    ->where($qb->expr()->like('g.name', ':search'))
                    ->orWhere($qb->expr()->like('h.name', ':search'))
                    ->orWhere($qb->expr()->like('q.name', ':search'))
                    ->orWhere($qb->expr()->like('p.name', ':search'))
                    ->orWhere($qb->expr()->like('a.name', ':search'))
                    ->setParameter('search', '%' . $values['search'] . '%');
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
            }
            if(empty($values['filterTransport']) != true) {
                $qb
                    //track
                    ->leftJoin('e.track', 'b')
                    ->where('b IS NOT NULL')
                    ->leftJoin('b.transport', 'g')
                    //event
                    ->leftJoin('e.event', 'o')
                    ->where('o IS NOT NULL')
                    ->leftJoin('o.transport', 'p')

                    ->where('g.name IN (:transports)')
                    ->orWhere('p.name IN (:transports)')
                    ->setParameter('transports', $values['filterTransport']);
            }
			if ($values['filterSortBy'] == '') {
				$qb
					->orderBy('e.date', 'DESC');
			}
            return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }

    public function findByFiltersCount($values)
    {
        if($values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->photos->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Photo', 'e');
            if($values['filterEntity'] == 'Event') {
                $qb
                    ->leftJoin('e.event', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            } elseif($values['filterEntity'] == 'Track') {
                $qb
                    ->leftJoin('e.track', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            } elseif($values['filterEntity'] == 'Place') {
                $qb
                    ->leftJoin('e.place', 'o')
                    ->where('o IS NOT NULL')
                    ->where('o.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
            }
            return $qb->getQuery()->getSingleScalarResult();

        } else {
            $qb = $this->photos->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Photo', 'e');

            if($values['search'] != '') {
                $qb
                    //track
                    ->leftJoin('e.track', 'b')
                    ->where('b IS NOT NULL')
                    ->leftJoin('b.place', 'g')
                    ->leftJoin('b.placeTo','h')
                    ->where('h IS NOT NULL')
                    //event
                    ->leftJoin('e.event', 'o')
                    ->where('o IS NOT NULL')
                    ->leftJoin('o.place', 'p')
                    ->leftJoin('o.placeTo','q')
                    ->where('q IS NOT NULL')
                    //place
                    ->leftJoin('e.place', 'a')
                    ->where('a IS NOT NULL')
                    ->where($qb->expr()->like('g.name', ':search'))
                    ->orWhere($qb->expr()->like('h.name', ':search'))
                    ->orWhere($qb->expr()->like('q.name', ':search'))
                    ->orWhere($qb->expr()->like('p.name', ':search'))
                    ->orWhere($qb->expr()->like('a.name', ':search'))
                    ->setParameter('search', '%' . $values['search'] . '%');
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
            }
            if(empty($values['filterTransport']) != true) {
                $qb
                    //track
                    ->leftJoin('e.track', 'y')
                    ->where('y IS NOT NULL')
                    ->leftJoin('y.transport', 'g')
                    //event
                    ->leftJoin('e.event', 'x')
                    ->where('x IS NOT NULL')
                    ->leftJoin('x.transport', 't')

                    ->where('g.name IN (:transports)')
                    ->orWhere('t.name IN (:transports)')
                    ->setParameter('transports', $values['filterTransport']);
            }
            return $qb->getQuery()->getSingleScalarResult();
        }
    }
}