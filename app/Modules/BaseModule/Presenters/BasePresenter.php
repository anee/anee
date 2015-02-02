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
	 * @var \ViewKeeper\ViewKeeper
	 * @inject
	 */
	public $keeper;

	public function formatLayoutTemplateFiles()
	{
		return array($this->keeper->getView($this->name, 'layouts', 'layout'));
	}

	public function formatTemplateFiles()
	{
		return array($this->keeper->getView($this->name, 'presenters', $this->action));
	}

	protected function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);
		$template->addFilter(NULL, 'App\TemplateHelpers::loader');
		return $template;
	}

	/**
	 * @return CssLoader
	 */
	protected function createComponentCssScreen()
	{
		/** @var \WebLoader\Compiler $compiler */
		$compiler = $this->context->getService('webloader.cssDefaultCompiler');
		$compiler->addFileFilter(new \WebLoader\Filter\LessFilter());
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
