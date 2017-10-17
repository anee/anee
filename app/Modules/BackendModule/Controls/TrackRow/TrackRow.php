<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\Place;
use App\Model\PlaceBaseLogic;
use App\Model\TrackBaseLogic;
use App\Model\TransportBaseLogic;
use App\Model\UserBaseLogic;
use App\Utils\TimeUtils;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Track;
use App\Model\User;
use Nette\Application\UI\Form;
use App\Model\Transport;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITrackRowFactory
{

	/**
	 * @param Track $track
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @param bool $byName
	 * @param bool $detail
	 * @return TrackRow
	 */
	function create(Track $track, User $loggedUser = NULL, User $profileUser, $byName = NULL, $detail = NULL);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackRow extends Control
{

	/**
	 * @var \App\Model\UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var \App\Model\TrackBaseLogic
	 */
	public $trackBaseLogic;

	/**
	 * @var \App\Model\TransportBaseLogic
	 */
	public $transportBaseLogic;

	/**
	 * @var \App\Model\PlaceBaseLogic
	 */
	public $placeBaseLogic;

	/**
	 * @var \App\Model\User
	 */
	private $loggedUser;

	/**
	 * @var \App\Model\User
	 */
	private $profileUser;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	/**
	 * @var \App\Model\Track
	 */
	private $track;

	/**
	 * @var bool which say if is home page or profile page
	 */
	private $byName;

	/** @var bool which say if is detail of concrete track or not
	 */
	private $detail;

	public function __construct(Track $track, User $loggedUser = NULL, User $profileUser, $byName = NULL, $detail = NULL, ViewKeeper $keeper, TransportBaseLogic $transportBaseLogic, PlaceBaseLogic $placeBaseLogic, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic)
	{
		$this->keeper = $keeper;
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

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'TrackRow', 'controls'));

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

		$place = "";
		if ($this->track->place != NULL) {
			$place = $this->track->place->getName();
		}
		$placeTo = "";
		if ($this->track->placeTo != NULL) {
			$placeTo = $this->track->placeTo->getName();
		}
		$transport = "";
		if ($this->track->transport != NULL) {
			$transport = $this->track->transport->getName();
		}

		$form->addText('distance')
			->setRequired('You have not filled distance.')
			->setAttribute('placeholder', '0')
			->setDefaultValue($this->track->distance);
		$form->addText('maxSpeed')
			->setAttribute('placeholder', 'N/A')
			->setDefaultValue($this->track->maxSpeed);
		$form->addText('dateHours')
			->setAttribute('placeholder', '0')
			->setDefaultValue(TimeUtils::fromSecondsHours($this->track->timeInSeconds));
		$form->addText('dateMinutes')
			->setAttribute('placeholder', '0')
			->setDefaultValue(TimeUtils::fromSecondsMinutes($this->track->timeInSeconds));
		$form->addText('dateSeconds')
			->setAttribute('placeholder', '0')
			->setDefaultValue(TimeUtils::fromSecondsSeconds($this->track->timeInSeconds));
		$form->addText('place')
			->setRequired('Place name is not valid.')
			->setAttribute('placeholder', 'place')
			->setDefaultValue($place);
		$form->addText('placeTo')
			->setAttribute('placeholder', 'place')
			->setDefaultValue($placeTo);
		$form->addText('transport')
			->setAttribute('placeholder', 'transport')
			->setRequired('Transport is empty.')
			->setDefaultValue($transport);
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

			/** Change $maxSpeed */
			if ($values->maxSpeed != '') {
				$track->maxSpeed = $values->maxSpeed;
			} else {
				$track->maxSpeed = 0;
			}

			/** Change $timeInSeconds */
			$this->track->timeInSeconds = TimeUtils::fromSpanToSeconds($values->dateHours, $values->dateMinutes, $values->dateSeconds);

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
			if ($values->placeTo != '') {
				$placeTo = $this->placeBaseLogic->findOneByNameAndUserName($values->placeTo, $this->loggedUser->username);
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
					$track->transport = $transport;
				} else {
					$transport = new Transport($values->placeTo, $this->loggedUser);
					$this->transportBaseLogic->save($transport);
					$track->transport = $transport;
				}
			}

			$this->trackBaseLogic->save($track);

			$this->redirect('this');
		}
	}
}