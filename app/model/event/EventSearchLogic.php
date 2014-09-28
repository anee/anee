<?php

namespace App\Model;

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

		if($values['search'] != '') {
			$query->addFilterBySearch($values['search']);
		}
		if(empty($values['filterTransport']) != true) {
			$query->addFilterByTransport($values['filterTransport']);
		}
		if($values['filterTime'] != '') {
			$query->addFilterByTime(Arrays::timeSubFilterTime($values['filterTime']));
		}
		return $query;
	}

	/**
	 * @param $values
	 * @return EventSearchQuery
	 */
	public function createEntityQuery($values){
		$query = (new EventSearchQuery());

		$query->addFilterByEntity($values['filterEntity'], $values['filterEntityId']);
		if($values['filterTime'] != '')	{
			$query->addFilterByTime(Arrays::timeSubFilterTime($values['filterTime']));
		}
		return $query;
	}

	/**
	 * @param $values
	 * @param $results
	 * @return $results
	 */
	public function findByFilters($values, $results)
	{
		if(Arrays::arrayContainsOrEmpty('Events', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortByDate();

			$results['events'] = $this->events->fetch($query);
			$results['count'] += count($results['events']);

		} elseif(Arrays::arrayContainsOrEmpty('Events', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortByDate();

			$results['events'] = $this->events->fetch($query);
			$results['count'] += count($results['events']);
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
			$results['eventsCount'] = $query->count($this->events);
		} else {
			$query = $this->createBasicQuery($values);
			$results['eventsCount'] = $query->count($this->events);
		}
		return $results;
	}
}