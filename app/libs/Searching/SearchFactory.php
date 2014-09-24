<?php

namespace App\Searching;

use App\Model;
use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchFactory extends Nette\Object
{
	/** @var \App\Model\EventRepository */
    private $eventRepository;

	/** @var \App\Model\TrackRepository */
	private $trackRepository;

	/** @var \App\Model\PhotoRepository */
	private $photoRepository;

	/** @var \App\Model\PlaceRepository */
	private $placeRepository;

	/** @var array */
	private $values = array();

	/** @var array */
	private $results = array();

    public function __construct(Model\EventRepository $eventRepository, Model\TrackRepository $trackRepository, Model\PhotoRepository $photoRepository, Model\PlaceRepository $placeRepository)
    {
		$this->eventRepository = $eventRepository;
		$this->trackRepository  = $trackRepository;
		$this->photoRepository  = $photoRepository;
		$this->placeRepository  = $placeRepository;

		$this->values = Utils::clearValuesArray();
		$this->results = Utils::clearResultsArray();
    }

	/**
	 * Main method which return results.
	 * @return array
	 */
	public function getNewResults() {
		$events = $this->eventRepository->findByFilters($this->values);
		$tracks = $this->trackRepository->findByFilters($this->values);
		$places = $this->placeRepository->findByFilters($this->values);
		$photos = $this->photoRepository->findByFilters($this->values);

		$eventsCount = $this->eventRepository->findByFiltersCount($this->values);
		$tracksCount = $this->trackRepository->findByFiltersCount($this->values);
		$placesCount = $this->placeRepository->findByFiltersCount($this->values);
		$photosCount = $this->photoRepository->findByFiltersCount($this->values);

		$entityObject = null;
		$entityUrl = "";
		if ($this->values['filterEntity'] == 'Event') {
			$entityObject = $this->eventRepository->findById($this->values['filterEntityId']);
			$entityUrl = 'Event:detail';
		} elseif ($this->values['filterEntity'] == 'Track') {
			$entityObject = $this->trackRepository->findById($this->values['filterEntityId']);
			$entityUrl = 'Track:detail';
		} elseif ($this->values['filterEntity'] == 'Place') {
			$entityObject = $this->placeRepository->findById($this->values['filterEntityId']);
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