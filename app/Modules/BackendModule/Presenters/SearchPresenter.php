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

	public function renderDefault($username)
	{
		$this->template->background = $this->getBackgroundImage($username);
	}

	protected function createComponentSearchTitle()
	{
		return $this->ISearchTitle->create($this->searchFactory->getValues(), $this->searchFactory->getResults());
	}

	public function getBackgroundImage($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		return $this->thumbnailsHelper->process('../app/data/users/'.$user->id.'/images/'.$user->backgroundImage, '1920x');
	}
}
