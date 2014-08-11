<?php

namespace App\Modules\FrontModule\Presenters;

use App\Modules\FrontModule\Forms;

/**
 * Homepage presenter.
 */
class PhotoPresenter extends BasePresenter
{

    /** @var \App\Model\PhotoRepository @inject*/
    public $photoRepository;

    public function renderDefault()
    {
        $this->template->photos = $this->photoRepository->findAll();
    }
}
