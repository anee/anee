<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 1.3.14
 * Time: 18:43
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;


class EventFacade extends Nette\Object
{
    /** @var \App\Model\EventRepository */
    public $eventRepository;

    private $www;

    public function __construct(EventRepository $eventRepository, $www)
    {
        $this->eventRepository = $eventRepository;
        $this->www = $www;
    }

    public function createEvent($values)
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

    public function removeEvent($id)
    {
        /*$work = $this->workRepository->findById($id);
        if($work != null) {
            unlink($work->getThumbnailpath());
            $this->workRepository->remove($id);
        }*/
    }
}