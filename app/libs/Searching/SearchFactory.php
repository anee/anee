<?php

namespace App\Searching;

use App\Model;
use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchFactory extends Nette\Object
{
	/** @var \App\Model\EventBaseLogic */
    private $eventBaseLogic;

	/** @var \App\Model\EventSearchLogic */
	private $eventSearchLogic;

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

	/** @var array */
	private $values = array();

	/** @var \App\Searching\SearchResults */
	private $results;

    public function __construct(Model\EventBaseLogic $eventBaseLogic, Model\EventSearchLogic $eventSearchLogic, Model\TrackBaseLogic $trackBaseLogic, Model\TrackSearchLogic $trackSearchLogic,
								Model\PhotoBaseLogic $photoBaseLogic, Model\PhotoSearchLogic $photoSearchLogic, Model\PlaceBaseLogic $placeBaseLogic, Model\PlaceSearchLogic $placeSearchLogic,
								Model\TransportBaseLogic $transportBaseLogic)
    {
		$this->eventBaseLogic = $eventBaseLogic;
		$this->eventSearchLogic = $eventSearchLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->trackSearchLogic = $trackSearchLogic;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->photoSearchLogic = $photoSearchLogic;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->placeSearchLogic = $placeSearchLogic;
		$this->transportBaseLogic = $transportBaseLogic;

		$this->values = Utils::clearValuesArray();
		$this->results = new SearchResults();
    }

	public function getResults()
	{
		$values = $this->values;
		$results = $this->results;

		$results = $this->eventSearchLogic->findByFilters($values, $results);
		$results = $this->eventSearchLogic->findByFiltersCount($values, $results);
		$results = $this->trackSearchLogic->findByFilters($values, $results);
		$results = $this->trackSearchLogic->findByFiltersCount($values, $results);
		$results = $this->photoSearchLogic->findByFilters($values, $results);
		$results = $this->photoSearchLogic->findByFiltersCount($values, $results);
		$results = $this->placeSearchLogic->findByFilters($values, $results);
		$results = $this->placeSearchLogic->findByFiltersCount($values, $results);

		if ($values['filterEntity'] == 'Event') {
			$results->setEntityObject($this->eventBaseLogic->findById($values['filterEntityId']));
			$results->setEntityUrl('Event:detail');
		} elseif ($values['filterEntity'] == 'Track') {
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
	 * @return array
	 */
	public function getMenuInfo()
	{
		return array(
			'transports' => $this->transportBaseLogic->findAll(),
			'events' => $this->eventBaseLogic->findAllCount(),
			'tracks' => $this->trackBaseLogic->findAllCount(),
			'places' => $this->placeBaseLogic->findAllCount(),
			'photos' => $this->photoBaseLogic->findAllCount(),
			'distance' => round($this->trackBaseLogic->distanceSum() + $this->eventBaseLogic->distanceSum(), 2)
		);
	}
}