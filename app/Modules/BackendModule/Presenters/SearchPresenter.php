<?php

namespace App\Modules\BackendModule\Presenters;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchPresenter extends BasePresenter
{
	/** @var \App\Modules\BackendModule\Controls\ITrackRow @inject */
	public $ITrackRow;

	/** @var \App\Modules\BackendModule\Controls\IPlaceRow @inject */
	public $IPlaceRow;

	/** @var \App\Modules\BackendModule\Controls\IPhotoRow @inject */
	public $IPhotoRow;

	/** @var \App\Searching\SearchFactory @inject */
	public $searchFactory;

	/** @var  \App\Modules\BackendModule\Controls\ISearchTitle @inject */
	public $ISearchTitle;

	public function actionDefault($username)
	{
		/** Init search factory */
		$this->searchFactory->setValues($this->getParameter('values'));
		$this->searchFactory->setUser($username);

		/** ==> byName = NULL, there are all results only for one user */
		if ($username != NULL) {
			$profileUser = $this->userBaseLogic->findOneByUsername($username);
			$loggedUser = $this->userBaseLogic->findOneById($this->user->id);

			/** Added all tracks from search results */
			foreach ($this->searchFactory->getResults()->getTracks() as $track) {
				$this->addComponent($this->createComponentTrackRow($track, $loggedUser, $profileUser, FALSE), 'Track' . $track->id);
			}

			/** Added all places from search results */
			foreach ($this->searchFactory->getResults()->getPlaces() as $place) {
				$this->addComponent($this->createComponentPlaceRow($place, $loggedUser, $profileUser), 'Place' . $place->id);
			}

			/** Added all photos from search results */
			foreach ($this->searchFactory->getResults()->getPhotos() as $photo) {
				$this->addComponent($this->createComponentPhotoRow($photo, $loggedUser, $profileUser), 'Photo' . $photo->id);
			}
		}
	}

	public function renderDefault($username)
	{
		$this->template->background = $this->getBackgroundImage($username);
	}

	protected function createComponentSearchTitle()
	{
		return $this->ISearchTitle->create($this->searchFactory->getValues(), $this->searchFactory->getResults());
	}

	public function getBackgroundImage($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		return $this->thumbnailsHelper->process('../app/data/users/'.$user->id.'/images/'.$user->backgroundImage, '1920x');
	}

	protected function createComponentTrackRow($track, $loggedUser, $profileUser, $byName = NULL)
	{
		return $this->ITrackRow->create($track, $loggedUser, $profileUser, $byName);
	}

	protected function createComponentPlaceRow($place, $loggedUser, $profileUser)
	{
		return $this->IPlaceRow->create($place, $loggedUser, $profileUser);
	}

	protected function createComponentPhotoRow($photo, $loggedUser, $profileUser)
	{
		return $this->IPhotoRow->create($photo, $loggedUser, $profileUser);
	}
}
