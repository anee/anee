<?php

namespace App\Modules\BackendModule\Presenters;

use Nette\Security as NS;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{


	public function renderDefault($username)
	{
		if ($username != NULL) {
			if ($this->user->isLoggedIn()) {
				if ($username != $this->getUser()->getIdentity()->data['username']) {
					$this->redirect(':Backend:Homepage:default', array('username' => $this->getUser()->getIdentity()->data['username']));
				}
			} else {
				$this->redirect(':Security:Sign:in');
			}
		} else {
			if ($this->user->isLoggedIn()) {
				$this->redirect(':Backend:Homepage:default', array('username' => $this->getUser()->getIdentity()->data['username']));
			}
			$this->redirect(':Security:Sign:in');
		}
	}
}
