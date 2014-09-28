<?php


namespace App\Model;

use Kdyby\Persistence\Queryable;
use Doctrine\ORM\QueryBuilder;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventSearchQuery extends BaseSearchQuery
{


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
			if(empty($transport) != true) {
				$qb
					->join('e.transport', 'c')
					->andWhere('c.name IN (:transports)')
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
					->join('e.place', 'a')
					->leftJoin('e.placeTo', 'b')
					->where('b IS NOT NULL')
					->where($qb->expr()->like('a.name', ':search'))
					->orWhere($qb->expr()->like('b.name', ':search'))
					->orWhere($qb->expr()->like('e.description', ':search'))
					->setParameter('search', '%' . $search . '%');
			}
		};
		return $this;
	}

	/**
	 * @param Queryable $repository
	 * @return \Kdyby\Doctrine\QueryBuilder
	 */
	protected function createBasicDql(Queryable $repository)
	{
		$qb = $repository->createQueryBuilder()
			->select('e')->from('App\Model\Event', 'e');

		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}