<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoFacade extends Nette\Object
{
    /** @var \App\Model\PhotoRepository */
    public $photoRepository;

    public $www;

    public function __construct(PhotoRepository $photoRepository, $www)
    {
        $this->photoRepository = $photoRepository;
        $this->www = $www;
    }

    public function createPhoto($values)
    {
        $filename = null;
        $filepath = null;

        foreach($values->thumbnail as $thumb) {
            if ($thumb->getSanitizedName() != null) {
                if ($thumb->isOk()) {
                    $filename = $thumb->getSanitizedName();
                    $filepath = "/images/photos/$filename";
                    $thumb->move($this->www."/images/photos/$filename");
                }
                $photo = new Photo($filename, $filepath);
                $this->photoRepository->save($photo);
            }
        }
    }

    public function removePhoto($id)
    {
        $photo = $this->photoRepository->findById($id);
        if($photo != null) {
            unlink($photo->getPath());
            $this->photoRepository->remove($id);
        }
    }

    public function getWww()
    {
        return $this->www;
    }
}