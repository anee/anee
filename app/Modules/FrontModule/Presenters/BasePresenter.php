<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;
use App\Modules\FrontModule\Forms\TInjectSearchFormFactory;
use App\Utils;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    use TInjectSearchFormFactory;

    /** @var \App\Model\PhotoRepository @inject*/
    public $photoRepository;

    /** @var \App\Model\TrackRepository @inject*/
    public $trackRepository;

    /** @var \App\Model\EventRepository @inject*/
    public $eventRepository;

    /** @var \App\Model\PlaceRepository @inject*/
    public $placeRepository;

    /** @var \App\Model\TransportRepository @inject*/
    public $transportRepository;

    /** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
    public $thumbnailsHelper;

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);

        // RIGHT MENU
        $template->dataCounts = array(
            'Transports' => $this->transportRepository->findAll(),
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

    /**
     * @return \App\Modules\FrontModule\Forms\SearchFormFactory
     */
    protected function createComponentSearchFormFactory()
    {
        return $this->searchFormFactory->create($this);
    }
}
