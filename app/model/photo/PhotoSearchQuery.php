<?php


namespace App\Model;

use Doctrine\ORM\QueryBuilder;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoSearchQuery extends BaseSearchQuery
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
					->leftJoin('e.place', 'eEntity');
			} elseif($entityName == 'Track') {
				$qb
					->leftJoin('e.track', 'eEntity');
			}
			$qb
				->where('eEntity IS NOT NULL')
				->where('eEntity.id = :id')
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
					->leftJoin('e.track', 'eTrack')
					->where('eTrack IS NOT NULL')
					->leftJoin('eTrack.transport', 'eTrackTransport')

					->where('eTrackTransport.name IN (:transports)')
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
					->leftJoin('e.track', 'eTrack')
					->leftJoin('eTrack.place', 'eTrackPlace')
					->leftJoin('eTrack.placeTo', 'eTrackPlaceTo')
					->leftJoin('e.place', 'ePlace')

					->where($qb->expr()->like('eTrackPlace.name', ':search'))
					->orWhere($qb->expr()->like('eTrackPlaceTo.name', ':search'))
					->orWhere($qb->expr()->like('ePlace.name', ':search'))
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
		return $qb->select('e')->from('App\Model\Photo', 'e');
	}
}