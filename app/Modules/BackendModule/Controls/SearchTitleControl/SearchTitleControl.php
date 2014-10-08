<?php


namespace App\Modules\BackendModule\Controls;


use App\Searching\SearchResults;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchTitleControl extends Control {


	private $values;
	private $results;

	public function __construct(Array $values, SearchResults $results)
	{
		$this->values = $values;
		$this->results = $results;
	}

	public function render()
	{
		$template = $this->template;

		// HELPERS
		$template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$template->setFile(__DIR__ . '/searchTitle.latte');

		$template->results = $this->results;
		$template->values = $this->values;

		$template->render();
	}
} 