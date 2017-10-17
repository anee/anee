<?php

namespace App\Model;

use Kdyby\Doctrine\EntityDao;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class BaseFacade {

	/**
	 * @var EntityDao
	 */
	protected $dao;

	public function __construct(EntityDao $dao)
	{
		$this->dao = $dao;
	}

    /**
     * @param $entity
     *
     * @return array
     */
	public function save($entity)
	{
		return $this->dao->save($entity);
	}
}