<?php

namespace App\Modules\FrontModule\Presenters;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var \App\Model\EventBaseLogic @inject*/
	public $eventBaseLogic;

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\PhotoBaseLogic @inject*/
	public $photoBaseLogic;

	public function renderDefault()
	{
        $this->template->event = $this->eventBaseLogic->findLast();
        $this->template->tracks = $this->trackBaseLogic->findLastByCount(2);
        $this->template->photos = $this->photoBaseLogic->findLastByCount(4);
	}
}
