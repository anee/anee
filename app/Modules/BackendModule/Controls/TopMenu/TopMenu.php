<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use App\Model\TrackBaseLogic;
use App\Model\PhotoBaseLogic;
use App\Searching\Utils;
use App\Utils\TimeUtils;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITopMenuFactory
{

  /**
   * @return TopMenu
   */
  function create();
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TopMenu extends Control
{

  /**
   * @var \ViewKeeper\ViewKeeper
   */
  public $keeper;

	private $usernameUrl;

	/**
   * @var \App\Model\UserBaseLogic
   */
  public $userBaseLogic;

  /**
   * @var \App\Model\PhotoBaseLogic
   */
  public $photoBaseLogic;

  /**
   * @var \App\Model\TrackBaseLogic
   */
  public $trackBaseLogic;

  public function __construct(ViewKeeper $keeper, UserBaseLogic $userBaseLogic, TrackBaseLogic $trackBaseLogic, PhotoBaseLogic $photoBaseLogic)
  {
    $this->keeper = $keeper;
    $this->userBaseLogic = $userBaseLogic;
    $this->photoBaseLogic = $photoBaseLogic;
    $this->trackBaseLogic = $trackBaseLogic;
  }

	public function render()
	{
    $this->template->setFile($this->keeper->getView('Backend:' . 'TopMenu', 'controls'));
		$this->template->render();
	}

  protected function createComponentSearchForForm()
  {
    $user = $this->userBaseLogic->findOneByUsername($this->getPresenter()->getParameter('username'));
    if($user != NULL) {
      $this->usernameUrl = $user->usernameUrl;
    } elseif ($this->getPresenter()->getUser()->isLoggedIn()) {
      $user = $this->userBaseLogic->findOneByUsername($this->getPresenter()->getUser()->getIdentity()->data['username']);
      $this->usernameUrl = $this->userBaseLogic->findOneByUsername($this->getPresenter()->getUser()->getIdentity()->data['username'])->usernameUrl;
    }

		$transports = array();
		foreach($this->userBaseLogic->findOneByUsernameUrl($this->usernameUrl)->transports as $transport) {
			$transports[$transport->name] = ucfirst($transport->name);
		}

		$form = new Form;
    $form->addText('search')->setAttribute('placeholder', 'Search...');
    $category = Utils::getCategories();
    $time = array(
        '' => 'Any time'
    /* 'Custom range...' => 'Custom range...',*/
    );
    $times = array_merge($time, Utils::getFromStartStrings());
    $times = array_merge($times, $this->trackBaseLogic->findAllYears($user->getId()));
    $sorts = array(
		     '' => 'DateTime'
		);
    $form->addMultiSelect('filterCategory', NULL, $category)->getControlPrototype()->setClass('filter-multiselect');
    $form->addMultiSelect('filterTransport', NULL, $transports);
    $form->addSelect('filterTime', NULL, $times);
		$form->addSelect('filterSortBy', NULL, $sorts);
    $form->addSubmit('send', '');
    $form->onSuccess[] = $this->success;
    return $form;
  }

  public function success(Form $form)
  {
    $this->presenter->redirect(':Backend:Search:default', array('values' => array_filter($form->getValues(true)), 'username' => $this->usernameUrl));
  }
}
