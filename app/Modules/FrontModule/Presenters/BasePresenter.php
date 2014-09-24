<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;
use App\Modules\FrontModule\Components\TInjectSearchFormFactory;



/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    use TInjectSearchFormFactory;

    /** @var \App\Model\PhotoBaseLogic @inject*/
    public $photoBaseLogic;

    /** @var \App\Model\TrackBaseLogic @inject*/
    public $trackBaseLogic;

    /** @var \App\Model\EventBaseLogic @inject*/
    public $eventBaseLogic;

    /** @var \App\Model\PlaceBaseLogic @inject*/
    public $placeBaseLogic;

    /** @var \App\Model\TransportBaseLogic @inject*/
    public $transportBaseLogic;

    /** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
    public $thumbnailsHelper;

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);

        // RIGHT MENU
        $template->dataCounts = array(
            'transports' => $this->transportBaseLogic->findAll(),
            'events' => $this->eventBaseLogic->findAllCount(),
            'tracks' => $this->trackBaseLogic->findAllCount(),
            'places' => $this->placeBaseLogic->findAllCount(),
            'photos' => $this->photoBaseLogic->findAllCount(),
            'distance' => round($this->trackBaseLogic->distanceSum() + $this->eventBaseLogic->distanceSum(), 2)
        );

        // HELPERS
		$template->addFilter(NULL, 'App\TemplateHelpers::loader');
        $template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

        return $template;
    }

    /**
     * @return \App\Modules\FrontModule\Components\SearchFormFactory
     */
    protected function createComponentSearchFormFactory()
    {
        return $this->searchFormFactory->create($this);
    }
}
