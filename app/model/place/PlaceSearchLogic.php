<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;
use App\Model;


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

	/** @var \App\Model\EventBaseLogic */
	private $eventBaseLogic;

    public function __construct(EntityDao $places, EntityDao $tracks, EventBaseLogic $eventBaseLogic, TrackBaseLogic $trackBaseLogic)
    {
        $this->places = $places;
        $this->tracks = $tracks;
        $this->eventBaseLogic = $eventBaseLogic;
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
			$tracks = $this->tracks->fetch($query);

			$places = array();
			foreach($tracks as $track) {
				 if(Arrays::arrayContains($track->placeTo, $places) != true) {
                 	$places[] = $track->placeTo;
                 }
			}
			return $places;
		} elseif($values['filterEntity'] == 'Track') {
			$track = $this->trackBaseLogic->findById($values['filterEntityId']);

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
		} elseif($values['filterEntity'] == 'Event') {
			$event = $this->eventBaseLogic->findById($values['filterEntityId']);

            $places = array();
            foreach ($event->photos as $photo) {
                if($photo->place != NULL && Arrays::arrayContains($photo->place, $places) != true) {
                    $places[] = $photo->place;
                }
            }
            if(Arrays::arrayContains($event->place, $places) != true) {
                $places[] = $event->place;
            }
            if($event->placeTo != NULL && Arrays::arrayContains($event->placeTo, $places) != true) {
                $places[] = $event->placeTo;
            }
			return $places;
		}
	}

	/**
	 * @param $values
	 * @param $results
	 * @return $results
	 */
	public function findByFilters($values, $results)
	{
		if(Arrays::arrayContainsOrEmpty('Places', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$array = $this->createEntityQuery($values);
			$results['places'] = $array;
			$results['count'] += count($array);
		} elseif(Arrays::arrayContainsOrEmpty('Places', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy('Name', $values['filterSortBy']);
			$results['places'] = $this->places->fetch($query);
			$results['count'] += count($results['places']);
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
			$results['placesCount'] = count($array);
		} else {
			$query = $this->createBasicQuery($values);
			$results['placesCount'] = $query->count($this->places);
		}
		return $results;
	}

}