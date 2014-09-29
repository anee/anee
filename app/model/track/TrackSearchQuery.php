<?php


namespace App\Model;

use Doctrine\ORM\QueryBuilder;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackSearchQuery extends BaseSearchQuery
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
					->leftJoin('e.place', 'ePlace')
					->where('ePlace.id = :id')
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
			if(empty($values['filterTransport']) != true) {
				$qb
					->join('e.transport', 'eTransport')
					->andWhere('eTransport.name IN (:transports)')
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
					->join('e.place', 'ePlace')
					->leftJoin('e.placeTo', 'ePlaceTo')

					->where($qb->expr()->like('ePlace.name', ':search'))
					->orWhere($qb->expr()->like('ePlaceTo.name', ':search'))
					->setParameter('search', '%' . $search . '%');
			}
		};
		return $this;
	}

	/**
	 * @param \Kdyby\Doctrine\QueryBuilder $qb
	 * @return \Kdyby\Doctrine\QueryBuilder
	 */
	protected function addBaseSelect(\Kdyby\Doctrine\QueryBuilder $qb)
	{
		return $qb->select('e')->from('App\Model\Track', 'e');
	}
}