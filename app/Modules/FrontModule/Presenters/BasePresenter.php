<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;
use App\Modules\FrontModule\Components\TInjectSearchFormFactory;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

    /** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
    public $thumbnailsHelper;

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);
        $template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

        return $template;
    }
}
