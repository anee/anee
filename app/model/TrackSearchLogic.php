<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackSearchLogic extends Nette\Object {

    private $tracks;

    public function __construct(EntityDao $dao)
    {
        $this->tracks = $dao;
    }

    public function findByFilters($values)
    {
        if(Arrays::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->tracks->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Track', 'e');

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
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
            }
			if ($values['filterSortBy'] == '') {
				$qb
					->orderBy('e.date', 'DESC');
			}
            return $qb->getQuery()->getResult();

        } elseif(Arrays::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true) {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e');

        if($values['search'] != '') {
            $qb
                ->join('e.place', 'a')
                ->leftJoin('e.placeTo', 'b')
                ->where('b IS NOT NULL')
                ->where($qb->expr()->like('a.name', ':search'))
                ->where($qb->expr()->like('b.name', ':search'))
                ->setParameter('search', '%' . $values['search'] . '%');
        }
        if($values['filterTime'] != '') {
            $qb
                ->andWhere('e.date >= :date')
                ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
        }
        if(empty($values['filterTransport']) != true) {
			$qb
				->join('e.transport', 'c')
				->andWhere('c.name IN (:transports)')
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
            $qb = $this->tracks->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Track', 'e');
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
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
            }
            return $qb->getQuery()->getSingleScalarResult();

        } else {
            $qb = $this->tracks->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Track', 'e');
            if($values['search'] != '') {
                $qb
                    ->join('e.place', 'a')
                    ->leftJoin('e.placeTo', 'b')
                    ->where('b IS NOT NULL')
                    ->where($qb->expr()->like('a.name', ':search'))
                    ->where($qb->expr()->like('b.name', ':search'))
                    ->setParameter('search', '%' . $values['search'] . '%');
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
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