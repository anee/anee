<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Forms;

/**
 * Homepage presenter.
 */
class EventPresenter extends BasePresenter
{
    /** @var Forms\CommentForm @inject */
    public $commentFormFactory;

	public function renderDefault()
	{

	}

    protected function createComponentCommentForm()
    {
        return $this->commentFormFactory->create();
    }
}
