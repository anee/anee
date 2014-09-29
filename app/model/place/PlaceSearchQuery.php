<?php


namespace App\Model;

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
					->leftJoin('e.tracks', 'eTracks')
					->leftJoin('eTracks.transport', 'eTracksTransport')

					->leftJoin('e.events', 'eEvents')
					->leftJoin('eEvents.transport', 'eEventsTransport')

					->where('eTracksTransport.name IN (:transports)')
					->orWhere('eEventsTransport.name IN (:transports)')
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
	 * @param \Kdyby\Doctrine\QueryBuilder $qb
	 * @return \Kdyby\Doctrine\QueryBuilder
	 */
	protected function addBaseSelect(\Kdyby\Doctrine\QueryBuilder $qb)
	{
		return $qb->select('e')->from('App\Model\Place', 'e');
	}
}