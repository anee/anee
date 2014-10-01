<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Components;
use App\Searching;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchPresenter extends BasePresenter
{
	/** @var \App\Searching\SearchFactory @inject */
	public $searchFactory;


	public function actionDefault()
	{
		$this->searchFactory->setValues($this->getParameter('values'));
	}

	public function renderDefault()
	{
		$this->template->results = $this->searchFactory->getResults();
		$this->template->values = $this->searchFactory->getValues();
	}
}
