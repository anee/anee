<?php

namespace App\Model;

use App\Searching\SearchResults;
use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;
use App\Model;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackSearchLogic extends Nette\Object {


	/** @var EntityDao */
    private $tracks;

    public function __construct(EntityDao $dao)
    {
        $this->tracks = $dao;
    }

	/**
	 * @param $values
	 * @return TrackSearchQuery
	 */
	public function createBasicQuery($values){
		$query = (new TrackSearchQuery());
		$query->addFilterBySearch($values['search']);
		$query->addFilterByTransport($values['filterTransport']);
		$query->addFilterByTime($values['filterTimeStart'], $values['filterTimeEnd']);
		$query->addFilterByUser($values['userId']);
		return $query;
	}

	/**
	 * @param $values
	 * @return TrackSearchQuery
	 */
	public function createEntityQuery($values){
		$query = (new TrackSearchQuery());
		$query->addFilterByEntity($values['filterEntity'], $values['filterEntityId']);
		$query->addFilterByTime($values['filterTimeStart'], $values['filterTimeEnd']);
		$query->addFilterByUser($values['userId']);
		return $query;
	}

	/**
	 * @param $values
	 * @param SearchResults $results
	 * @return SearchResults
	 */
    public function findByFilters($values, SearchResults $results)
    {
		if(Arrays::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results->setTracks($this->tracks->fetch($query));

        } elseif(Arrays::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results->setTracks($this->tracks->fetch($query));
        }
		return $results;
    }

	/**
	 * @param $values
	 * @param SearchResults $results
	 * @return SearchResults
	 */
    public function findByFiltersCount($values, SearchResults $results)
    {
        if($values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$results->setTrackCount($query->count($this->tracks));
        } else {
			$query = $this->createBasicQuery($values);
			$results->setTrackCount($query->count($this->tracks));
        }
		return $results;
    }
}