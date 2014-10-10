<?php

namespace App\Modules\FrontendModule\Presenters;

use Nette\Security as NS;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	public function formatLayoutTemplateFiles()
	{
		$files = parent::formatLayoutTemplateFiles();
		$files[] = __DIR__ . '/../templates/@layout.latte';

		return $files;
	}

	public function renderAbout()
	{

	}
}
