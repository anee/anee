<?php


namespace App\Searching;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchResults {



	private $entityObject;
	private $entityUrl;

	private $events;
	private $tracks;
	private $places;
	private $photos;

	private $eventsCount;
	private $tracksCount;
	private $photosCount;
	private $placesCount;

	private $count;

	public function __construct()
	{
		$this->events = array();
		$this->tracks = array();
		$this->photos = array();
		$this->places = array();
		$this->eventsCount = 0;
		$this->tracksCount = 0;
		$this->placesCount = 0;
		$this->photosCount = 0;
		$this->count = 0;
		$this->entityObject = NULL;
		$this->entityUrl = '';
	}

	public function getCount()
	{
		return $this->count;
	}

	public function setEvents($resultSet)
	{
		$this->events = $resultSet;
		$this->count += count($resultSet);
	}

	public function getEvents()
	{
		return $this->events;
	}

	public function setEventsCount($count)
	{
		$this->eventsCount = $count;
	}

	public function getEventsCount()
	{
		return $this->eventsCount;
	}

	public function setTracks($resultSet)
	{
		$this->tracks = $resultSet;
		$this->count += count($resultSet);
	}

	public function getTracks()
	{
		return $this->tracks;
	}

	public function setTrackCount($count)
	{
		$this->tracksCount = $count;
	}

	public function getTracksCount()
	{
		return $this->eventsCount;
	}

	public function setPhotos($resultSet)
	{
		$this->photos = $resultSet;
		$this->count += count($resultSet);
	}

	public function getPhotos()
	{
		return $this->photos;
	}

	public function setPhotosCount($count)
	{
		$this->photosCount = $count;
	}

	public function getPhotosCount()
	{
		return $this->photosCount;
	}

	public function setPlaces($resultSet)
	{
		$this->places = $resultSet;
		$this->count += count($resultSet);
	}

	public function getPlaces()
	{
		return $this->places;
	}

	public function setPlacesCount($count)
	{
		$this->placesCount = $count;
	}

	public function getPlacesCount()
	{
		return $this->placesCount;
	}

	public function setEntityObject($object)
	{
		$this->entityObject = $object;
	}

	public function getEntityObject()
	{
		return $this->entityObject;
	}

	public function setEntityUrl($url)
	{
		$this->entityUrl = $url;
	}

	public function getEntityUrl()
	{
		return $this->getEntityUrl();
	}
} 