<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;
use App\Utils\Arrays;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoSearchLogic extends  Nette\Object {


	/** @var EntityDao */
    private $photos;

    public function __construct(EntityDao $dao)
    {
        $this->photos = $dao;
    }

	/**
	 * @param $values
	 * @return PhotoSearchQuery
	 */
	public function createBasicQuery($values){

		$query = (new PhotoSearchQuery());

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
	 * @return PhotoSearchQuery
	 */
	public function createEntityQuery($values){
		$query = (new PhotoSearchQuery());

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
		if(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortByDate();

			$results['photos'] = $this->s->fetch($query);
			$results['count'] += count($results['photos']);

		} elseif(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortByDate();

			$results['photos'] = $this->photos->fetch($query);
			$results['count'] += count($results['photos']);
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
			$results['photosCount'] = $query->count($this->photos);
		} else {
			$query = $this->createBasicQuery($values);
			$results['photosCount'] = $query->count($this->photos);
		}
		return $results;
	}
}