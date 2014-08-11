<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;

/**
 * Homepage presenter.
 */
class TrackPresenter extends BasePresenter
{
    /** @var \App\Model\TrackRepository @inject*/
    public $trackRepository;

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
