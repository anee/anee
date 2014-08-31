<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;
use App\Modules\FrontModule\Forms;
use App\Utils;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var Forms\SearchForm @inject */
    public $searchFormFactory;

    /** @var \App\Model\PhotoRepository @inject*/
    public $photoRepository;

    /** @var \App\Model\TrackRepository @inject*/
    public $trackRepository;

    /** @var \App\Model\EventRepository @inject*/
    public $eventRepository;

    /** @var \App\Model\PlaceRepository @inject*/
    public $placeRepository;

    /** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
    public $thumbnailsHelper;

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);

        // RIGHT MENU
        $template->dataCounts = array(
            'Events' => $this->eventRepository->findAllCount(),
            'Tracks' => $this->trackRepository->findAllCount(),
            'Places' => $this->placeRepository->findAllCount(),
            'Photos' => $this->photoRepository->findAllCount(),
            'Distance' => round($this->trackRepository->distanceSum() + $this->eventRepository->distanceSum(), 2)
        );

        // HELPERS
        Utils\helpers::loader($template);
        $template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

        return $template;
    }

    protected function createComponentSearchForm()
    {
        return $this->searchFormFactory->create($this);
    }
}
