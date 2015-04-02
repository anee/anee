<?php

namespace App\Model;

use Kdyby\Doctrine\QueryBuilder;

/**
 * Class TrackBaseQuery
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class TrackBaseQuery extends BaseQuery {


	protected function addBaseSelect(QueryBuilder $qb)
	{
		return $qb->select('e')->from('App\Model\Track', 'e');
	}
}