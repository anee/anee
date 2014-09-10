<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackFacade extends Nette\Object
{
    /** @var \App\Model\TrackRepository */
    public $trackRepository;

    private $www;

    public function __construct(TrackRepository $trackRepository, $www)
    {
        $this->trackRepository = $trackRepository;
        $this->www = $www;
    }

    public function createTrack($values)
    {
        /*$filename = null;
        $filepath = null;
        if ($values->thumbnail->getSanitizedName() != null) {
            if ($values->thumbnail->isOk()) {
                $filename = $values->thumbnail->getSanitizedName();
                $filepath = "/images/work/$filename";
                $values->thumbnail->move($filepath);
            }
            $work = new Work($values->name, $values->url, $filename, $filepath);
            $this->workRepository->save($work);
        }*/
    }

    public function removeTrack($id)
    {
        /*$work = $this->workRepository->findById($id);
        if($work != null) {
            unlink($work->getThumbnailpath());
            $this->workRepository->remove($id);
        }*/
    }
}