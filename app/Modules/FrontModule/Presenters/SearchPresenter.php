<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Components;
use App\Searching;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchPresenter extends BasePresenter
{
	/** @var \App\Searching\SearchFactory @inject*/
	public $searching;

    public function actionDefault()
    {
		$this->searching->setValues($this->getParameter('values'));
    }

	public function renderDefault()
	{
		$this->template->values = $this->searching->getValues();
		$this->template->results = $this->searching->getNewResults();
	}
}
