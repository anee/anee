<?php


namespace App\Model;

use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;
use Doctrine\ORM\QueryBuilder;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackSearchQuery extends QueryObject
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
					->leftJoin('e.place', 'o')
					->where('o IS NOT NULL')
					->where('o.id = :id')
					->setParameter('id', $entityId);
			}
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
			$qb
				->join('e.transport', 'c')
				->andWhere('c.name IN (:transports)')
				->setParameter('transports', $transport);
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
			$qb
				->join('e.place', 'a')
				->leftJoin('e.placeTo', 'b')
				->where('b IS NOT NULL')
				->where($qb->expr()->like('a.name', ':search'))
				->orWhere($qb->expr()->like('b.name', ':search'))
				->setParameter('search', '%' . $search . '%');
		};
		return $this;
	}

	/**
	 * @param $date
	 * @return $this
	 */
	public function addFilterByTime($date)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($date) {
			$qb
				->andWhere('e.date >= :date')
				->setParameter('date', $date);
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
			->select('e')->from('App\Model\Track', 'e');

		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}