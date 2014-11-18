<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\Place;
use App\Model\PlaceBaseLogic;
use App\Model\TrackBaseLogic;
use App\Model\TransportBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Track;
use App\Model\User;
use Nette\Application\UI\Form;
use App\Model\Transport;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackRow extends Control
{

	/** @var \App\Model\UserBaseLogic */
	public $userBaseLogic;

	/** @var \App\Model\TrackBaseLogic */
	public $trackBaseLogic;

	/** @var \App\Model\TransportBaseLogic */
	public $transportBaseLogic;

	/** @var \App\Model\PlaceBaseLogic */
	public $placeBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	/** @var \App\Model\User */
	private $profileUser;

	/** @var \App\Model\Track */
	private $track;

	/** @var bool which say if is home page or profile page */
	private $byName;

	/** @var bool which say if is detail of concrete track or not */
	private $detail;

    public function __construct(TransportBaseLogic $transportBaseLogic, PlaceBaseLogic $placeBaseLogic, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, Track $track, User $loggedUser, User $profileUser, $byName = NULL, $detail = NULL)
    {
		$this->track = $track;
		$this->transportBaseLogic = $transportBaseLogic;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->byName = $byName;
		$this->detail = $detail;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->track = $this->track;
		$this->template->byName = $this->byName;
		$this->template->detail = $this->detail;

		$this->template->render();
	}

	public function handlePin($id)
	{
		if ($this->getPresenter()->isAjax()) {
			$track = $this->trackBaseLogic->findOneById($id);
			$track->pinned = TRUE;
			$this->trackBaseLogic->save($track);

			$this->redirect('this');
		}
	}

	public function handleUnpin($id)
	{
		if ($this->getPresenter()->isAjax()) {
			$track = $this->trackBaseLogic->findOneById($id);
			$track->pinned = FALSE;
			$this->trackBaseLogic->save($track);

			$this->redirect('this');
		}
	}

	public function handleRemove($id)
	{
		if ($this->getPresenter()->isAjax()) {
			$this->trackBaseLogic->remove($id);

			$this->redirect('this');
		}
	}

	protected function createComponentTrackEditForm()
	{
		$form = new Form;

		$form->addText('distance')
			->setRequired('You have not filled distance.')
			->setAttribute('placeholder', '0')
			->setDefaultValue($this->track->distance);
		$form->addText('place')
			->setRequired('Place name is not valid.')
			->setAttribute('placeholder', 'place')
			->setDefaultValue($this->track->place->name);
		$form->addText('placeTo')
			->setAttribute('placeholder', 'place')
			->setDefaultValue($this->track->placeTo->name);
		$form->addText('transport')
			->setAttribute('placeholder', 'transport')
			->setRequired('Transport is empty.')
			->setDefaultValue($this->track->transport->name);
		$form->addSubmit('save', 'save changes');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {

			$values = $form->getValues();
			$track = $this->track;

			/** Change $distance */
			$track->distance = $values->distance;

			/** Change $place */
			if ($values->place != $track->place->name) {
				$place = $this->placeBaseLogic->findOneByNameAndUserName($values->place, $this->loggedUser->username);
				if ($place != NULL) {
					$track->place = $place;
				} else {
					$place = new Place($values->place, $this->loggedUser);
					$this->placeBaseLogic->save($place);
					$track->place = $place;
				}
			}

			/** Change $placeTo */
			if ($values->placeTo != '' || $values->placeTo != $track->placeTo->name) {
				$placeTo = $this->placeBaseLogic->findOneByNameAndUserName($values->place, $this->loggedUser->username);
				if ($placeTo != NULL) {
					$track->placeTo = $placeTo;
				} else {
					$placeTo = new Place($values->placeTo, $this->loggedUser);
					$this->placeBaseLogic->save($placeTo);
					$track->placeTo = $placeTo;
				}
			}

			/** Change transport */
			if ($values->transport != '') {
				$transport = $this->transportBaseLogic->findOneByNameAndUserId($values->transport, $this->loggedUser->id);
				if ($transport != NULL) {
					$track->transport  = $transport ;
				} else {
					$transport  = new Transport($values->placeTo, $this->loggedUser);
					$this->transportBaseLogic->save($transport);
					$track->transport = $transport;
				}
			}

			$this->trackBaseLogic->save($track);

			$this->redirect('this');
		}
	}
}