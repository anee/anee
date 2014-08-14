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
        $this->template->places = $this->placeRepository->findByFilters($this->values);
        $this->template->events = $this->eventRepository->findByFilters($this->values);
        $this->template->tracks = $this->trackRepository->findByFilters($this->values);
        $this->template->photos = $this->photoRepository->findByFilters($this->values);
	}
}
