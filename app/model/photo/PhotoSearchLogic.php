<?php

namespace App\Model;

use App\Searching\SearchResults;
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
		$query->addFilterByUser($values['userId']);
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
		if(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
			$query = $this->createEntityQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results->setPhotos($this->photos->fetch($query));
		} elseif(Arrays::arrayContainsOrEmpty('Photos', $values['filterCategory']) == true) {
			$query = $this->createBasicQuery($values);
			$query->addSortBy($values['filterSortBy']);
			$results->setPhotos($this->photos->fetch($query));
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
			$results->setPhotosCount($query->count($this->photos));
		} else {
			$query = $this->createBasicQuery($values);
			$results->setPhotosCount($query->count($this->photos));
		}
		return $results;
	}
}