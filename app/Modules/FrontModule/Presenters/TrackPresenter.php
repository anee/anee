<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackPresenter extends BasePresenter
{

    public $track;

	public function renderDetail($id)
	{
        $this->track = $this->trackRepository->findById($id);

        if ($this->track == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->track = $this->track;
        }
	}
}
