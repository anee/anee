<?php

namespace App\Modules\BaseModule\Presenters;

use Nette;
use App\Modules\FrontModule\Components\TInjectSearchFormFactory;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    use TInjectSearchFormFactory;

	/** @var \App\Searching\SearchFactory @inject */
	public $searchFactory;

	public function formatLayoutTemplateFiles()
	{
		$files = parent::formatLayoutTemplateFiles();
		$files[] = __DIR__ . '/../templates/@layout.latte';

		return $files;
	}

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);
		$template->menuInfo = $this->searchFactory->getMenuInfo();

        // HELPERS
		$template->addFilter(NULL, 'App\TemplateHelpers::loader');

        return $template;
    }

    /**
     * @return \App\Modules\FrontModule\Components\SearchFormFactory
     */
    protected function createComponentSearchFormFactory()
    {
        return $this->searchFormFactory->create($this);
    }

	/**
	 * @return CssLoader
	 */
	protected function createComponentCssScreen()
	{
		/** @var \WebLoader\Compiler $compiler */
		$compiler = $this->context->getService('webloader.cssDefaultCompiler');
		$loader = new CssLoader($compiler, $this->template->basePath . '/webtemp');

		return $loader;
	}


	/**
	 * @return JavaScriptLoader
	 */
	protected function createComponentJs()
	{
		/** @var \WebLoader\Compiler $compiler */
		$compiler = $this->context->getService('webloader.jsDefaultCompiler');

		return new JavaScriptLoader($compiler, $this->template->basePath . '/webtemp');
	}
}
