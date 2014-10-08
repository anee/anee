<?php


namespace App\Model;

use Kdyby\Doctrine\EntityDao;
use Kdyby\Doctrine\QueryBuilder;
use Nette\Object;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class BaseLogic extends Object
{

	/** @var EntityDao */
	protected $dao;

	public function __construct(EntityDao $dao)
	{
		$this->dao = $dao;
	}

	public function save($entity)
	{
		$this->dao->save($entity);
	}

	public function addFilterByUser(QueryBuilder $qb, $userId)
	{
		return $qb
			->join('e.user', 'eUser')
			->andWhere('eUser.id = :userId')
			->setParameter('userId', $userId);
	}
} 