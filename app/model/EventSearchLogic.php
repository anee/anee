<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventSearchLogic extends Nette\Object {

	private $events;

	public function __construct(EntityDao $dao)
	{
		$this->events = $dao;
	}

	public function findByFilters($values)
	{
		if(Arrays::arrayContainsOrEmpty('Events', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
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
					->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
			}
			$qb
				->orderBy('e.date', 'DESC');
			return $qb->getQuery()->getResult();

		} elseif(Arrays::arrayContainsOrEmpty('Events', $values['filterCategory']) == true) {
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
					->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
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
					->setParameter('date', Arrays::timeSubFilterTime($values['filterTime']));
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