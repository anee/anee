<?php

namespace App\Modules\BaseModule\Presenters;

use Nette;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @return CssLoader
	 */
	protected function createComponentCssScreen()
	{
		/** @var \WebLoader\Compiler $compiler */
		$compiler = $this->context->getService('webloader.cssDefaultCompiler');
		$control = new CssLoader($compiler, '/webtemp');

		return $control;
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
