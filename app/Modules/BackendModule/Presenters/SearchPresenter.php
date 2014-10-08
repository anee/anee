<?php

namespace App\Modules\BackendModule\Presenters;


use App\Modules\BackendModule\Controls\SearchTitleControl;


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

	public function createComponentSearchTitle()
	{
		return new SearchTitleControl($this->searchFactory->getValues(), $this->searchFactory->getResults());
	}
}
