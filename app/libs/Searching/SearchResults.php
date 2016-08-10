<?php


namespace App\Searching;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchResults {

	private $entityObject;
	private $entityUrl;

	private $tracks;
	private $places;
	private $photos;

	private $tracksCount;
	private $photosCount;
	private $placesCount;

	private $count;

	public function __construct()
	{
		$this->tracks = array();
		$this->photos = array();
		$this->places = array();
		$this->tracksCount = 0;
		$this->placesCount = 0;
		$this->photosCount = 0;
		$this->count = 0;
		$this->entityObject = NULL;
		$this->entityUrl = '';
	}

	public function getTotalCount()
	{
		return $this->tracksCount + $this->placesCount + $this->photosCount;
	}

	public function getSelectedCount()
	{
		return $this->count;
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
		return $this->tracksCount;
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
		return $this->entityUrl;
	}

    public function getCountForCategory($category)
    {
        if($category == 'Tracks') {
            return $this->getTracksCount();
        } elseif($category == 'Places') {
            return $this->getPlacesCount();
        } elseif($category == 'Photos') {
            return $this->getPhotosCount();
        }
        return null;
    }
}