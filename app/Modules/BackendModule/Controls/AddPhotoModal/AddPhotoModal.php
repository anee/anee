<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use App\Model\PhotoBaseLogic;
use App\Model\TrackBaseLogic;
use App\Model\PlaceBaseLogic;
use Nette\Application\UI\Form;
use App\Model\User;
use App\Model\Photo;
use Nette\Utils\DateTime;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IAddPhotoModalFactory
{

	/**
	 * @param User $loggedUser
	 * @return AddPhotoModal
	 */
	function create(User $loggedUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddPhotoModal extends Control
{

	/**
	 * @var UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var PhotoBaseLogic
	 */
	public $photoBaseLogic;

	/**
	 * @var TrackBaseLogic
	 */
	public $trackBaseLogic;

	/**
	 * @var PlaceBaseLogic
	 */
	public $placeBaseLogic;

	/**
	 * @var User */
	private $loggedUser;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	private $appDir;

	public function __construct(ViewKeeper $keeper, PlaceBaseLogic $placeBaseLogic, TrackBaseLogic $trackBaseLogic, PhotoBaseLogic $photoBaseLogic, UserBaseLogic $userBaseLogic, $appDir, User $loggedUser)
	{
		$this->keeper = $keeper;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->appDir = $appDir;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . $this->name, 'controls'));
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentAddPhotoForm()
	{
		$places = Array();
		$places[''] = '';
		foreach($this->loggedUser->places as $place) {
			$places[$place->id] = $place->name;
		}

		$tracks = Array();
		$tracks[''] = '';
		foreach($this->loggedUser->tracks as $track) {
			$tracks[$track->id] = $track->getName().' - '.$track->date->format('d.m.Y H:i:s');
		}

		$form = new Form;
		$form->addUpload('photo');
		$form->addSelect('place', NULL, $places);
		$form->addSelect('track', NULL, $tracks);
		$date = new DateTime();
		$form->addText('date')->setDefaultValue($date->format('Y-m-d H:i:s'));
		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			$values = $form->getValues();
			$user = $this->loggedUser;
			
			$filename = null;
			$filePath = null;
			if ($values->photo->getSanitizedName() != null) {
				if ($values->photo->isOk()) {
					$filename = $values->photo->getSanitizedName();
					$filePath = $this->appDir."/data/users/".$this->loggedUser->id."/photos/$filename";
					$values->photo->move($filePath);

					// new photo
					$photo = new Photo($user, $filename, $filePath, new DateTime($values->date));
					if ($values->track != '') {
						$photo->track = $this->trackBaseLogic->findOneById($values->track);
					}
					if ($values->place != '') {
						$photo->place = $this->placeBaseLogic->findOneById($values->place);
					}
					$this->photoBaseLogic->save($photo);
				}
			}
			
			$this->getPresenter()->redirect('this');
		}
	}
}