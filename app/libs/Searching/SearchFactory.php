<?php

namespace App\Searching;

use App\Model;
use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchFactory extends Nette\Object
{

	/** @var \App\Model\TrackBaseLogic */
	private $trackBaseLogic;

	/** @var \App\Model\TrackSearchLogic */
	private $trackSearchLogic;

	/** @var \App\Model\PhotoBaseLogic */
	private $photoBaseLogic;

	/** @var \App\Model\PhotoSearchLogic */
	private $photoSearchLogic;

	/** @var \App\Model\PlaceBaseLogic */
	private $placeBaseLogic;

	/** @var \App\Model\PlaceSearchLogic */
	private $placeSearchLogic;

	/** @var \App\Model\TransportBaseLogic */
	private $transportBaseLogic;

	/** @var \App\Model\UserBaseLogic */
	private $userBaseLogic;

	/** @var array */
	private $values = array();

	/** @var \App\Searching\SearchResults */
	private $results;

    public function __construct(Model\TrackBaseLogic $trackBaseLogic, Model\TrackSearchLogic $trackSearchLogic,	Model\PhotoBaseLogic $photoBaseLogic, Model\PhotoSearchLogic $photoSearchLogic, Model\PlaceBaseLogic $placeBaseLogic,
								Model\PlaceSearchLogic $placeSearchLogic, Model\TransportBaseLogic $transportBaseLogic, Model\UserBaseLogic $userBaseLogic)
    {
		$this->trackBaseLogic = $trackBaseLogic;
		$this->trackSearchLogic = $trackSearchLogic;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->photoSearchLogic = $photoSearchLogic;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->placeSearchLogic = $placeSearchLogic;
		$this->transportBaseLogic = $transportBaseLogic;
		$this->userBaseLogic = $userBaseLogic;

		$this->values = Utils::clearValuesArray();
		$this->results = new SearchResults();
    }

	public function getResults()
	{
		$values = $this->values;
		$results = $this->results;

		$results = $this->trackSearchLogic->findByFilters($values, $results);
		$results = $this->trackSearchLogic->findByFiltersCount($values, $results);
		$results = $this->photoSearchLogic->findByFilters($values, $results);
		$results = $this->photoSearchLogic->findByFiltersCount($values, $results);
		$results = $this->placeSearchLogic->findByFilters($values, $results);
		$results = $this->placeSearchLogic->findByFiltersCount($values, $results);

		if ($values['filterEntity'] == 'Track') {
			$results->setEntityObject($this->trackBaseLogic->findById($values['filterEntityId']));
			$results->setEntityUrl('Track:detail');
		} elseif ($values['filterEntity'] == 'Place') {
			$results->setEntityObject($this->placeBaseLogic->findById($values['filterEntityId']));
		}

		$this->results = $results;
		return $results;
	}

	/**
	 * Sets the searching input values.
	 * @param array
	 * @return array
	 */
	public function setValues($values)
	{
		$this->values = Utils::checkValuesArray($values);
	}

	/**
	 * Returns the searching output without new calculate.
	 * @return array
	 */
	public function getLastResults()
	{
		return $this->results;
	}

	/**
	 * Returns the searching input.
	 * @return array
	 */
	public function getValues()
	{
		return $this->values;
	}

	/**
	 * @param $username
	 */
	public function setUser($username)
	{
		$this->values['username'] = $username;
		$this->values['userId']= $this->userBaseLogic->findOneByUsername($username)->id;
	}
}