<?php


namespace App\Model;

use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;
use Doctrine\ORM\QueryBuilder;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceSearchQuery extends QueryObject
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
	 * @param $transport
	 * @return $this
	 */
	public function addFilterByTransport($transport)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($transport) {
			$qb
				//track
				->leftJoin('e.tracks', 'b')
				->where('b IS NOT NULL')
				->leftJoin('b.transport', 'g')
				//event
				->leftJoin('e.events', 'o')
				->where('o IS NOT NULL')
				->leftJoin('o.transport', 'p')

				->where('g.name IN (:transports)')
				->orWhere('p.name IN (:transports)')
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
				->where($qb->expr()->like('e.name', ':search'))
				->setParameter('search', '%' . $search . '%');
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
					->addOrderBy('e.name', $order);
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
			->select('e')->from('App\Model\Place', 'e');

		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}