<?php


namespace App\Model;

use Kdyby\Persistence\Queryable;
use Doctrine\ORM\QueryBuilder;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceSearchQuery extends BaseSearchQuery
{


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
					->where($qb->expr()->like('e.name', ':search'))
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
			->select('e')->from('App\Model\Place', 'e');

		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}
}