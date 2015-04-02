<?php


namespace App\Model;

use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;
use Kdyby\Doctrine\QueryBuilder;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class BaseQuery extends QueryObject
{

	/**
	 * @var array|\Closure[]
	 */
	protected $filter = [];

	/**
	 * @var array|\Closure[]
	 */
	protected $select = [];

	public function byId($id)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($id) {
			$qb
				->andWhere('e.id = :id')
				->setParameter('id', $id);
		};
		return $this;
	}

	public function byUser($id)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($id) {
			$qb
				->leftJoin('e.user', 'user')
				->andWhere('user.id = :userId')
				->setParameter('userId', $id);
		};
		return $this;
	}

	/**
	 * @param \Kdyby\Doctrine\QueryBuilder $qb
	 * @return \Kdyby\Doctrine\QueryBuilder
	 */
	protected function addBaseSelect(QueryBuilder $qb)
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