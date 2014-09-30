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

    /** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
    public $thumbnailsHelper;

	/** @var \App\Searching\SearchFactory @inject */
	public $searchFactory;

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);
		$template->menuInfo = $this->searchFactory->getMenuInfo();

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
