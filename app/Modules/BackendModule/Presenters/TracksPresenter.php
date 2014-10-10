<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TracksPresenter extends BasePresenter
{

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\Track */
    public $track;

	public function renderDetail($id)
	{
        $this->track = $this->trackBaseLogic->findOneByIdAndUserId($id, $this->getUser()->getIdentity()->data['id']);

        if ($this->track == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->track = $this->track;
        }
	}
}
