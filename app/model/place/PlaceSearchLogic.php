<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;
use App\Model;
use App\Searching\SearchResults;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceSearchLogic extends Nette\Object {


	/** @var EntityDao */
    private $places;

	/** @var EntityDao */
    private $tracks;

	/** @var \App\Model\TrackBaseLogic */
	private $trackBaseLogic;

    public function __construct(EntityDao $places, EntityDao $tracks, TrackBaseLogic $trackBaseLogic)
    {
        $this->places = $places;
        $this->tracks = $tracks;
		$this->trackBaseLogic = $trackBaseLogic;
    }

	/**
	 * @param $values
	 * @return PlaceSearchQuery
	 */
	public function createBasicQuery($values){

		$query = (new PlaceSearchQuery());
		$query->addFilterBySearch($values['search']);
		$query->addFilterByTransport($values['filterTransport']);
		$query->addFilterByUser($values['userId']);
		return $query;
	}

	/**
	 * @param $values
	 * @return Array
	 */
	public function createEntityQuery($values){
		if($values['filterEntity'] == 'Place') {
			$query = (new TrackSearchQuery());
			$query->addFilterByEntity($values['filterEntity'], $values['filterEntityId']);
			$query->addFilterByUser($values['userId']);
			$tracks = $this->tracks->fetch($query);

			$places = array();
			foreach($tracks as $track) {
				 if(Arrays::arrayContains($track->placeTo, $places) != true) {
                 	$places[] = $track->placeTo;
                 }
			}
			return $places;
		} elseif($values['filterEntity'] == 'Track') {
			$track = $this->trackBaseLogic->findOneByIdAndUserId($values['filterEntityId'], $values['userId']);

            $places = array();
            foreach ($track->photos as $photo) {
                if($photo->place != NULL && Arrays::arrayContains($photo->place, $places) != true) {
                    $places[] = $photo->place;
                }
            }
            if(Arrays::arrayContains($track->place, $places) != true) {
                $places[] = $track->place;
            }
            if($track->placeTo != NULL && Arrays::arrayContains($track->placeTo, $places) != true) {
                $places[] = $track->placeTo;
            }
			return $places;
		}
	}

	/**
	 * @param $values
	 * @param SearchResults $results
	 * @return SearchResults
	 */
	public function findByFilters($values, SearchResults $results)
	{
		if(Arrays::arrayContainsOrEmpty('Places', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$array = $this->createEntityQuery($values);
			$results->setPlaces($array);
		} elseif(Arrays::arrayContainsOrEmpty('Places', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy('Name', $values['filterSortBy']);
			$results->setPlaces($this->places->fetch($query));
		}
		return $results;
	}

	/**
	 * @param $values
	 * @param $results
	 * @return $results
	 */
	public function findByFiltersCount($values, $results)
	{
		if($values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$array = $this->createEntityQuery($values);
			$results->setPlacesCount(count($array));
		} else {
			$query = $this->createBasicQuery($values);
			$results->setPlacesCount($query->count($this->places));
		}
		return $results;
	}

}