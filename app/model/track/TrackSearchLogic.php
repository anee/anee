<?php

namespace App\Model;

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

		if($values['search'] != '') {
			$query->addFilterBySearch($values['search']);
		}
		if(empty($values['filterTransport']) != true) {
			$query->addFilterByTransport($values['filterTransport']);
		}
		$query->addFilterByTime($values['filterTimeStart'], $values['filterTimeEnd']);
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
		return $query;
	}

	/**
	 * @param $values
	 * @param $results
	 * @return $results
	 */
    public function findByFilters($values, $results)
    {
		if(Arrays::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortBy($values['filterSortBy']);

			$results['tracks'] = $this->tracks->fetch($query);
			$results['count'] += count($results['tracks']);

        } elseif(Arrays::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy($values['filterSortBy']);

			$results['tracks'] = $this->tracks->fetch($query);
			$results['count'] += count($results['tracks']);
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
			$query = $this->createEntityQuery($values);
			$results['tracksCount'] = $query->count($this->tracks);
        } else {
			$query = $this->createBasicQuery($values);
			$results['tracksCount'] = $query->count($this->tracks);
        }
		return $results;
    }
}