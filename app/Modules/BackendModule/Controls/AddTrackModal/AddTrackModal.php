<?php

namespace App\Modules\BackendModule\Controls;

use App\Utils\Strings;
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
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IAddTrackModalFactory
{

	/**
	 * @param User $loggedUser
	 * @return AddTrackModal
	 */
	function create(User $loggedUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddTrackModal extends Control
{

	/**
	 * @var UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var TrackBaseLogic
	 */
	public $trackBaseLogic;

	/**
	 * @var PlaceBaseLogic
	 */
	public $placeBaseLogic;

	/**
	 * @var TransportBaseLogic
	 */
	public $transportBaseLogic;

	/**
	 * @var User
	 */
	private $loggedUser;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	private $appDir;


	public function __construct(ViewKeeper $keeper, TransportBaseLogic $transportBaseLogic, PlaceBaseLogic $placeBaseLogic, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, $appDir, User $loggedUser)
	{
		$this->keeper = $keeper;
		$this->transportBaseLogic = $transportBaseLogic;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->appDir = $appDir;
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'AddTrackModal', 'controls'));
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
			->setAttribute('placeholder', '00h 00m 00s');
		$form->addText('friendName')
			->setAttribute('placeholder', 'username');
		$date = new DateTime();
		$form->addText('date')->setDefaultValue($date->format('Y-m-d H:i:s'));
		$form->addCheckbox('pinned');
		$form->addText('avgSpeed')
			->setAttribute('placeholder', '0.00 km/h')
			->setDisabled();
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

			$seconds = intval(substr($values->timeInSeconds, 0, -9)) * 3600 + intval(substr($values->timeInSeconds, 4, -5) * 60) + intval(substr($values->timeInSeconds, 8, -1));
			$track = new Track($user, $transport, $values->distance, $seconds, $place, new DateTime($values->date), $values->pinned);
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