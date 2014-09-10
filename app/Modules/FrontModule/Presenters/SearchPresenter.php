<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Forms;
use App\FilterUtils;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
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
        if($this->values['filterEntity'] == 'Event') {
            $entityObject = $this->eventRepository->findById($this->values['filterEntityId']);
            $entityUrl = 'Event:detail';
        } elseif ($this->values['filterEntity'] == 'Track') {
            $entityObject = $this->trackRepository->findById($this->values['filterEntityId']);
            $entityUrl = 'Track:detail';
        } elseif ($this->values['filterEntity'] == 'Place') {
            $entityObject = $this->placeRepository->findById($this->values['filterEntityId']);
        }

        $this->template->results = array(
            'EntityObject' => $entityObject,
            'EntityUrl' => $entityUrl,
            'Count' => count($events) + count($tracks) + count($places) + count($photos),
            'Events' => $events,
            'Tracks' => $tracks,
            'Places' => $places,
            'Photos' => $photos,
            'EventsCount' => $eventsCount,
            'TracksCount' => $tracksCount,
            'PlacesCount' => $placesCount,
            'PhotosCount' => $photosCount
        );
	}
}
