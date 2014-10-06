<?php

namespace App\Modules\BaseModule\Presenters;

use Nette;
use App\Modules\FrontendModule\Components\TInjectSearchFormFactory;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function formatLayoutTemplateFiles()
	{
		$files = parent::formatLayoutTemplateFiles();
		$files[] = __DIR__ . '/../templates/@layout.latte';

		return $files;
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
