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

	/** @var \App\Model\EventBaseLogic */
	private $trackBaseLogic;

	/** @var \App\Model\TrackSearchLogic */
	private $trackSearchLogic;

	/** @var \App\Model\EventBaseLogic */
	private $photoBaseLogic;

	/** @var \App\Model\PhotoSearchLogic */
	private $photoSearchLogic;

	/** @var \App\Model\EventBaseLogic */
	private $placeBaseLogic;

	/** @var \App\Model\PlaceSearchLogic */
	private $placeSearchLogic;

	/** @var array */
	private $values = array();

	/** @var array */
	private $results = array();

    public function __construct(Model\EventBaseLogic $eventBaseLogic, Model\EventSearchLogic $eventSearchLogic, Model\TrackBaseLogic $trackBaseLogic, Model\TrackSearchLogic $trackSearchLogic,
								Model\PhotoBaseLogic $photoBaseLogic, Model\PhotoSearchLogic $photoSearchLogic, Model\PlaceBaseLogic $placeBaseLogic, Model\PlaceSearchLogic $placeSearchLogic)
    {
		$this->eventBaseLogic = $eventBaseLogic;
		$this->eventSearchLogic = $eventSearchLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->trackSearchLogic = $trackSearchLogic;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->photoSearchLogic = $photoSearchLogic;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->placeSearchLogic = $placeSearchLogic;

		$this->values = Utils::clearValuesArray();
		$this->results = Utils::clearResultsArray();
    }

	/**
	 * Main method which return results.
	 * @return array
	 */
	public function getNewResults() {
		$events = $this->eventSearchLogic->findByFilters($this->values);
		$tracks = $this->trackSearchLogic->findByFilters($this->values);
		$places = $this->placeSearchLogic->findByFilters($this->values);
		$photos = $this->photoSearchLogic->findByFilters($this->values);

		$eventsCount = $this->eventSearchLogic->findByFiltersCount($this->values);
		$tracksCount = $this->trackSearchLogic->findByFiltersCount($this->values);
		$placesCount = $this->placeSearchLogic->findByFiltersCount($this->values);
		$photosCount = $this->photoSearchLogic->findByFiltersCount($this->values);

		$entityObject = null;
		$entityUrl = "";
		if ($this->values['filterEntity'] == 'Event') {
			$entityObject = $this->eventBaseLogic->findById($this->values['filterEntityId']);
			$entityUrl = 'Event:detail';
		} elseif ($this->values['filterEntity'] == 'Track') {
			$entityObject = $this->trackBaseLogic->findById($this->values['filterEntityId']);
			$entityUrl = 'Track:detail';
		} elseif ($this->values['filterEntity'] == 'Place') {
			$entityObject = $this->placeBaseLogic->findById($this->values['filterEntityId']);
		}

		$this->results = array(
			'entityObject' => $entityObject,
			'entityUrl' => $entityUrl,
			'count' => count($events) + count($tracks) + count($places) + count($photos),
			'events' => $events,
			'tracks' => $tracks,
			'places' => $places,
			'photos' => $photos,
			'eventsCount' => $eventsCount,
			'tracksCount' => $tracksCount,
			'placesCount' => $placesCount,
			'photosCount' => $photosCount
		);
		return $this->results;
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
	 * Returns the searching output.
	 * @return array
	 */
	public function getResults()
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
}