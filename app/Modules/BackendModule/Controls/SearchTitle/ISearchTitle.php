<?php


namespace App\Modules\BackendModule\Controls;

use App\Searching\SearchResults;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ISearchTitle
{

	/**
	 * @param array $values
	 * @param SearchResults $results
	 * @return SearchTitle
	 */
	function create(Array $values, SearchResults $results);
}