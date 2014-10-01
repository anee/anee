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
		$query->addFilterBySearch($values['search']);
		$query->addFilterByTransport($values['filterTransport']);
		$query->addFilterByTime($values['filterTimeStart'], $values['filterTimeEnd']);
		return $query;
	}

	/**
	 * @param $values
	 * @return PhotoSearchQuery
	 */
	public function createEntityQuery($values){
		$query = (new PhotoSearchQuery());
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
		if(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results['photos'] = $this->photos->fetch($query);
			$results['count'] += count($results['photos']);
		} elseif(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy($values['filterSortBy']);
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