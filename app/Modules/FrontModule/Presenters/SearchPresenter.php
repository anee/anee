<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Forms;
use App\Utils\FilterUtils;

/**
 * Homepage presenter.
 */
class SearchPresenter extends BasePresenter
{
    public $values;

    public function actionDefault()
    {
        $this->values = FilterUtils::checkArray($this->getParameter('values'));
    }

	public function renderDefault()
	{

        $this->template->values = $this->values;

       /*dump($this->values);
        die();*/
        $events = $this->eventRepository->findByFilters($this->values);
        $tracks = $this->trackRepository->findByFilters($this->values);
        $places = $this->placeRepository->findByFilters($this->values);
        $photos = $this->photoRepository->findByFilters($this->values);
        /*$tracks = array();
        $places = array();
        $photos = array();*/

        $this->template->results = array(
            'Count' => count($events) + count($tracks) + count($places) + count($photos),
            'Events' => $events,
            'Tracks' => $tracks,
            'Places' => $places,
            'Photos' => $photos,
            'EventsCount' => $this->eventRepository->findByFiltersCount($this->values),
            'TracksCount' => $this->trackRepository->findByFiltersCount($this->values),
            'PlacesCount' => $this->placeRepository->findByFiltersCount($this->values),
            'PhotosCount' => $this->photoRepository->findByFiltersCount($this->values)
          /* 'TracksCount' => 0,
           'PlacesCount' => 0,
           'PhotosCount' => 0*/
        );
	}
}
