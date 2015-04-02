<?php

namespace App\Modules\RestApiModule\Presenters;

use Drahak\Restful\IResource;
use Kappa\Doctrine\Converters\Converter;

/**
 * Class PlacesPresenter
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class PlacesPresenter extends BasePresenter
{

	/** @var \App\Model\UserFacade @inject */
	public $userFacade;

	/** @var \App\Model\PlaceFacade @inject */
	public $placeFacade;

	/** @var Converter @inject */
	public $converter;

	public function actionRead($username = null, $id = null, $limit = null)
	{
		$user = $this->userFacade->getOneByUsername($username);
		if($user && $user->public) {

			if ($id == null) {
				$result = $this->placeFacade->getAll($user->id)->applyPaging(0, $limit);

				if ($result != null) {
					$resource = array();
					foreach ($result->toArray() as $result) {
						$resource[] = $this->prepareData($result);
					}
					$this->resource = $resource;
				} else {
					$this->setError();
				}
			} else {
				$result = $this->placeFacade->getOne($user->id, $id);

				if ($result != null) {
					$this->resource = $this->prepareData($result);
				} else {
					$this->setError();
				}
			}
		} else {
			$this->setError();
		}

		$this->sendResource(IResource::JSON);
	}

	private function prepareData($result)
	{
		return $this->converter->entityToArray($result)
			->setIgnoreList(array("nameUrl", "user"))
			->addFieldResolver("tracks", function ($tracks) {
				return count($tracks);
			})
			->addFieldResolver("photos", function ($photos) {
				return count($photos);
			})
			->convert();
	}
}
