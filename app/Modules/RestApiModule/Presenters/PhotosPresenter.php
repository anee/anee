<?php

namespace App\Modules\RestApiModule\Presenters;

use Drahak\Restful\IResource;
use Kappa\Doctrine\Converters\Converter;

/**
 * Class PhotosPresenter
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class PhotosPresenter extends BasePresenter
{

	/** @var \App\Model\UserFacade @inject */
	public $userFacade;

	/** @var \App\Model\PhotoFacade @inject */
	public $photoFacade;

	/** @var Converter @inject */
	public $converter;

	public function actionRead($username = null, $id = null, $count = null)
	{
		$user = $this->userFacade->getOneByUsername($username);
		if($user && $user->public) {

			if ($id == null) {
				$result = $this->photoFacade->getAll($user->id)->applyPaging(0, $count);

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
				$result = $this->photoFacade->getOne($user->id, $id);

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
			->setIgnoreList(array("user", "filePath"))
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
			->addFieldResolver("track", function ($track) {
				if($track) {
					return [
						'id' => $track->getId(),
						'name' => $track->getName()
					];
				} else {
					return 'NULL';
				}
			})
			->convert();
	}
}
