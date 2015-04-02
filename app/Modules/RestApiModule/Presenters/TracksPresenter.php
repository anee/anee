<?php

namespace App\Modules\RestApiModule\Presenters;

use Drahak\Restful\IResource;
use Kappa\Doctrine\Converters\Converter;

/**
 * Class TracksPresenter
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class TracksPresenter extends BasePresenter
{

	/** @var \App\Model\UserFacade @inject */
	public $userFacade;

	/** @var \App\Model\TrackFacade @inject */
	public $trackFacade;

	/** @var Converter @inject */
	public $converter;

	public function actionRead($username = null, $id = null, $limit = null)
	{
		$user = $this->userFacade->getOneByUsername($username);
		if($user && $user->public) {

			if ($id == null) {
				$result = $this->trackFacade->getAll($user->id)->applyPaging(0, $limit);

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
				$result = $this->trackFacade->getOne($user->id, $id);

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
			->setIgnoreList(array("photos", "withUsers", "user"))
			->addFieldResolver("place", function ($place) {
				if($place) {
					return [
						'id' => $place->getId(),
						'name' => $place->getName()
					];
				} else {
					return 'NULL';
				}
			})
			->addFieldResolver("placeTo", function ($placeTo) {
				if($placeTo) {
					return [
						'id' => $placeTo->getId(),
						'name' => $placeTo->getName()
					];
				} else {
					return 'NULL';
				}
			})
			->addFieldResolver("transport", function ($transport) {
				if($transport) {
					return [
						'id' => $transport->getId(),
						'name' => $transport->getName()
					];
				} else {
					return 'NULL';
				}
			})
			->convert();
	}
}
