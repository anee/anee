<?php


namespace App\Model;

use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;
use Doctrine\ORM\QueryBuilder;
use App\Utils\Arrays;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class BaseSearchQuery extends QueryObject
{

	/**
	 * @var array|\Closure[]
	 */
	protected $filter = [];


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
		$this->filter[] = function (QueryBuilder $qb) use ($sortBy, $order) {
			if($sortBy == 'Name') {
				$qb
					->addOrderBy('e.name', $order);
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
		return $this->createBasicDql($repository);
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
	protected function createBasicDql(Queryable $repository)
	{
		$qb = $repository->createQueryBuilder();

		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}