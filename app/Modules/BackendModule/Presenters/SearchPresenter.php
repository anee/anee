<?php

namespace App\Modules\BackendModule\Presenters;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchPresenter extends BasePresenter
{
	/** @var \App\Searching\SearchFactory @inject */
	public $searchFactory;

	/** @var  \App\Modules\BackendModule\Controls\ISearchTitle @inject */
	public $ISearchTitle;

	public function actionDefault($username)
	{
		$this->searchFactory->setValues($this->getParameter('values'));
		$this->searchFactory->setUser($username);
	}

	protected function createComponentSearchTitle()
	{
		return $this->ISearchTitle->create($this->searchFactory->getValues(), $this->searchFactory->getResults());
	}
}
