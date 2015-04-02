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

	public function save($entity)
	{
		$this->dao->save($entity);
	}
}