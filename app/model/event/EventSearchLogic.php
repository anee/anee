<?php

namespace App\Model;

use App\Searching\SearchResults;
use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventSearchLogic extends Nette\Object {


	/** @var EntityDao */
	private $events;

	public function __construct(EntityDao $dao)
	{
		$this->events = $dao;
	}

	/**
	 * @param $values
	 * @return EventSearchQuery
	 */
	public function createBasicQuery($values){
		$query = (new EventSearchQuery());
		$query->addFilterBySearch($values['search']);
		$query->addFilterByTransport($values['filterTransport']);
		$query->addFilterByTime($values['filterTimeStart'], $values['filterTimeEnd']);
		return $query;
	}

	/**
	 * @param $values
	 * @return EventSearchQuery
	 */
	public function createEntityQuery($values) {
		$query = (new EventSearchQuery());
		$query->addFilterByEntity($values['filterEntity'], $values['filterEntityId']);
		$query->addFilterByTime($values['filterTimeStart'], $values['filterTimeEnd']);
		return $query;
	}

	/**
	 * @param $values
	 * @param SearchResults $results
	 * @return SearchResults
	 */
	public function findByFilters($values, SearchResults $results)
	{
		if(Arrays::arrayContainsOrEmpty('Events', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results->setEvents($this->events->fetch($query));
		} elseif(Arrays::arrayContainsOrEmpty('Events', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results->setEvents($this->events->fetch($query));
		}
		return $results;
	}

	/**
	 * @param $values
	 * @param SearchResults $results
	 * @return SearchResults
	 */
	public function findByFiltersCount($values, $results)
	{
		if($values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$results->setEventsCount($query->count($this->events));
		} else {
			$query = $this->createBasicQuery($values);
			$results->setEventsCount($query->count($this->events));
		}
		return $results;
	}
}