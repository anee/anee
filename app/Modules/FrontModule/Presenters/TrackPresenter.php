<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackPresenter extends BasePresenter
{

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\Track */
    public $track;

	public function renderDetail($id)
	{
        $this->track = $this->trackBaseLogic->findById($id);

        if ($this->track == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->track = $this->track;
        }
	}
}
