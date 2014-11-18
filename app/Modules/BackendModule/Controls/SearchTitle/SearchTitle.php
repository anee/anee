<?php


namespace App\Modules\BackendModule\Controls;


use App\Searching\SearchResults;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchTitle extends Control {

	/** @var array */
	private $values;

	/** @var SearchResults */
	private $results;

	public function __construct(Array $values, SearchResults $results)
	{
		$this->values = $values;
		$this->results = $results;
	}

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->setFile($file);
		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->results = $this->results;
		$this->template->values = $this->values;

		$this->template->render();
	}
} 