<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use Nette\Application\UI\Form;
use App\Model\User;
use App\Model\Track;
use App\Model\Photo;
use App\Model\TransportBaseLogic;
use App\Model\PlaceBaseLogic;
use App\Model\TrackBaseLogic;
use Nette\Utils\DateTime;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddTrackModal extends Control
{

	/** @var UserBaseLogic @inject */
	public $userBaseLogic;

	/** @var TrackBaseLogic @inject */
	public $trackBaseLogic;

	/** @var PlaceBaseLogic @inject */
	public $placeBaseLogic;

	/** @var TransportBaseLogic  @inject */
	public $transportBaseLogic;

	/** @var User */
	private $loggedUser;

	private $appDir;


	public function __construct(TransportBaseLogic $transportBaseLogic, PlaceBaseLogic $placeBaseLogic, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, $appDir, User $loggedUser)
	{
		$this->transportBaseLogic = $transportBaseLogic;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->appDir = $appDir;
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentAddTrackForm()
	{
		$places = Array();
		$places[''] = '';
		foreach($this->loggedUser->places as $place) {
			$places[$place->id] = $place->name;
		}

		$transports = Array();
		foreach($this->loggedUser->transports as $transport) {
			$transports[$transport->id] = $transport->getName();
		}

		$form = new Form;
		$form->addText('distance')
			->setAttribute('placeholder', 'km')
			->setRequired('You have not filled distance.');
		$form->addText('maxSpeed')
			->setAttribute('placeholder', 'km/h');
		$form->addSelect('place', NULL, $places)
			->setRequired('You have not filled start place.');
		$form->addSelect('placeTo', NULL, $places);
		$form->addSelect('transport', NULL, $transports)
			->setRequired('You have not selected transport type.');
		$form->addText('timeInSeconds')
			->setAttribute('placeholder', 'in seconds');
		$form->addText('friendName')
			->setAttribute('placeholder', 'username');
		$date = new DateTime();
		$form->addText('date')->setDefaultValue($date->format('Y-m-d H:i:s'));
		$form->addCheckbox('pinned');

		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			$values = $form->getValues();

			$user = $this->loggedUser;
			$place = $this->placeBaseLogic->findOneById($values->place);
			$transport = $this->transportBaseLogic->findById($values->transport);

			$track = new Track($user, $transport, $values->distance, $values->timeInSeconds, $place, new DateTime($values->date), $values->pinned);
			if($values->maxSpeed != '') {
				$track->maxSpeed = $values->maxSpeed;
			}
			if($values->placeTo != '') {
				$track->placeTo = $this->placeBaseLogic->findOneById($values->placeTo);
			}
			if($values->friendName != NULL) {
				$friend = $this->userBaseLogic->findOneByUsername($values->friendName);
				$track->getWithUsers()->add($friend);
			}
			$this->trackBaseLogic->save($track);

			$this->getPresenter()->redirect('this');
		}
	}
}