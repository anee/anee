<?php

namespace App\Modules\FrontModule\Presenters;



/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
        $this->template->event = $this->eventRepository->findLast();
        $this->template->tracks = $this->trackRepository->findLastByCount(2);
        $this->template->photos = $this->photoRepository->findLastByCount(4);
	}
}
