<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Forms;


/**
 * Homepage presenter.
 */
class SearchPresenter extends BasePresenter
{

    public function actionDefault()
    {

    }

	public function renderDefault()
	{
        dump($this->getParameters());
        die();
        $this->template->search = '';//$this->getParameter('values' => 'search');
	}
}
