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

		/** Results to template, need know count of all */
		$this->template->results = $this->searchFactory->getResults();

		/** ==> byName = NULL, there are all results only for one user */
		if ($username != NULL) {
			$profileUser = $this->userBaseLogic->findOneByUsernameUrl($username);
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
		$this->template->background = $this->getBackgroundImage($this->userBaseLogic->findOneByUsernameUrl($username));
	}

	protected function createComponentSearchTitle()
	{
		return $this->ISearchTitle->create($this->searchFactory->getValues(), $this->searchFactory->getResults());
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
