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
	 * @var array|\Closure[]
	 */
	protected $select = [];


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
					->setParameter('start', Arrays::returnTimeStart($start));
			}
			if($end != '') {
				$qb
					->andWhere('e.date <= :end')
					->setParameter('end', Arrays::returnTimeEnd($end));
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
	 * @param $userId
	 * @return $this
	 */
	public function addFilterByUser($userId)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($userId) {
			$qb
				->join('e.user', 'eUser')
				->andWhere('eUser.id = :userId')
				->setParameter('userId', $userId);
		};
		return $this;
	}

	/**
	 * @param \Kdyby\Doctrine\QueryBuilder $qb
	 * @return \Kdyby\Doctrine\QueryBuilder
	 */
	protected function addBaseSelect(\Kdyby\Doctrine\QueryBuilder $qb)
	{
		return $qb;
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
	 * @return \Kdyby\Doctrine\QueryBuilder
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
		$qb = $this->addBaseSelect($qb);

		foreach ($this->select as $modifier) {
			$modifier($qb);
		}
		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}
