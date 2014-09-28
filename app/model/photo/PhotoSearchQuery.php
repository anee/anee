<?php


namespace App\Model;

use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;
use Doctrine\ORM\QueryBuilder;
use App\Utils\Arrays;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoSearchQuery extends QueryObject
{

	/**
	 * @var array|\Closure[]
	 */
	private $filter = [];

	/**
	 * @var array|\Closure[]
	 */
	private $select = [];


	/**
	 * @param $entityName
	 * @param $entityId
	 * @return $this
	 */
	public function addFilterByEntity($entityName, $entityId)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($entityName, $entityId) {
			if($entityName == 'Place') {
				$qb
					->leftJoin('e.place', 'o');
			} elseif($entityName == 'Track') {
				$qb
					->leftJoin('e.track', 'o');
			} elseif($entityName == 'Event') {
				$qb
					->leftJoin('e.event', 'o');
			}
			$qb
				->where('o IS NOT NULL')
				->where('o.id = :id')
				->setParameter('id', $entityId);
		};
		return $this;
	}

	/**
	 * @param $transport
	 * @return $this
	 */
	public function addFilterByTransport($transport)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($transport) {
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
					->setParameter('transports', $transport);
			}
		};
		return $this;
	}

	/**
	 * @param $search
	 * @return $this
	 */
	public function addFilterBySearch($search)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($search) {
			if($search != '') {
				$qb
					//track
					->leftJoin('e.track', 'b')
					->where('b IS NOT NULL')
					->leftJoin('b.place', 'g')
					->leftJoin('b.placeTo', 'h')
					->where('h IS NOT NULL')
					//event
					->leftJoin('e.event', 'o')
					->where('o IS NOT NULL')
					->leftJoin('o.place', 'p')
					->leftJoin('o.placeTo', 'q')
					->where('q IS NOT NULL')
					//place
					->leftJoin('e.place', 'a')
					->where('a IS NOT NULL')
					->where($qb->expr()->like('g.name', ':search'))
					->orWhere($qb->expr()->like('h.name', ':search'))
					->orWhere($qb->expr()->like('q.name', ':search'))
					->orWhere($qb->expr()->like('p.name', ':search'))
					->orWhere($qb->expr()->like('a.name', ':search'))
					->setParameter('search', '%' . $search . '%');
			}
		};
		return $this;
	}

	/**
	 * @param $start
	 * @param $end
	 * @return $this
	 */
	public function addFilterByTime($start, $end)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($start, $end) {
			if($start != '') {
				$qb
					->andWhere('e.date >= :start')
					->setParameter('date', Arrays::timeSubFilterTime($start));
			}
			if($end != '') {
				$qb
					->andWhere('e.date <= :end')
					->setParameter('end', Arrays::timeSubFilterTime($start));
			}
		};
		return $this;
	}

	/**
	 * @param $sortBy
	 * @param string $order
	 * @return $this
	 */
	public function addSortBy($sortBy, $order = 'DESC')
	{
		$this->select[] = function (QueryBuilder $qb) use ($sortBy, $order) {
			if(false) {

			} else {
				$qb
					->addOrderBy('e.date', $order);
			}
		};
		return $this;
	}

	/**
	 * @param \Kdyby\Persistence\Queryable $repository
	 * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
	 */
	protected function doCreateQuery(Queryable $repository)
	{
		$qb = $this->createBasicDql($repository);

		foreach ($this->select as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}

	/**
	 * @param Queryable $repository
	 * @return \Doctrine\ORM\Query|QueryBuilder|\Kdyby\Doctrine\QueryBuilder
	 */
	protected function doCreateCountQuery(Queryable $repository)
	{
		return $this->createBasicDql($repository)->select('COUNT(e.id)');
	}

	/**
	 * @param Queryable $repository
	 * @return \Kdyby\Doctrine\QueryBuilder
	 */
	private function createBasicDql(Queryable $repository)
	{
		$qb = $repository->createQueryBuilder()
			->select('e')->from('App\Model\Photo', 'e');

		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}