<?php

namespace App\Modules\BaseModule\Presenters;

use Nette;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;
use Kdyby\Autowired\AutowireProperties;



/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	use AutowireProperties;

	/**
	 * @var \Kappa\ThemesManager\Theme
	 * @autowire(default, factory=\Kappa\ThemesManager\ThemeFactory)
	 */
	protected $theme;

	public function formatLayoutTemplateFiles()
	{
		return $this->theme->getFormatLayoutTemplateFiles();
	}

	public function formatTemplateFiles()
	{
		return $this->theme->getFormatTemplateFiles();
	}

	public function getTemplateFactory()
	{
		$templateFactory = parent::getTemplateFactory();
		$templateFactory->setTheme($this->theme);

		return $templateFactory;
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
