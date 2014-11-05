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



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddPhotoModal extends Control
{

	/** @var UserBaseLogic @inject */
	public $userBaseLogic;

	/** @var PhotoBaseLogic @inject */
	public $photoBaseLogic;

	/** @var TrackBaseLogic  */
	public $trackBaseLogic;

	/** @var PlaceBaseLogic */
	public $placeBaseLogic;

	/** @var User */
	private $loggedUser;

	private $appDir;

	public function __construct(PlaceBaseLogic $placeBaseLogic, TrackBaseLogic $trackBaseLogic, PhotoBaseLogic $photoBaseLogic, UserBaseLogic $userBaseLogic, $appDir, User $loggedUser)
	{
		$this->placeBaseLogic = $placeBaseLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->appDir = $appDir;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render($file)
	{
		$this->template->setFile($file);
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
			$tracks[$track->id] = $track->getName().' - '.$track->date->format('d.m.Y');
		}

		$form = new Form;
		$form->addUpload('photo');
		$form->addSelect('places', NULL, $places);
		$form->addSelect('tracks', NULL, $tracks);
		$form->addText('date')->setDefaultValue('2012-06-15 14:45');
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
					$photo = new Photo($user, $filename, $filePath);
					if ($values->tracks != '') {
						$photo->track = $this->trackBaseLogic->findOneById($values->tracks);
					}
					if ($values->places != '') {
						$photo->place = $this->placeBaseLogic->findOneById($values->places);
					}
					$this->photoBaseLogic->save($photo);
				}
			}
			
			$this->getPresenter()->redirect('this');
		}
	}
}