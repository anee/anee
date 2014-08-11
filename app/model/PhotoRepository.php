<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 8.4.14
 * Time: 0:28
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;

class PhotoRepository extends Nette\Object {

    private $photos;

    public function __construct(EntityDao $dao)
    {
        $this->photos = $dao;
    }

    public function save($photo)
    {
        $this->photos->save($photo);
    }

    public function findLast()
    {
        return $this->photos->findOneBy(array(), array('id' => 'DESC'), 1);
    }

    public function findLastByCount($count)
    {
        return $this->photos->findBy(array(), array('id' => 'DESC'), $count);
    }

    public function findFromEnd($position)
    {
        $counter = 0;
        $photos = $this->photos->findBy(array(), array('id' => 'DESC'));

        foreach($photos as $photo) {
            $counter ++;
            if ($counter == $position)
                return $photo;
            }
        return NULL;
    }

    public function findAll()
    {
        return $this->photos->findBy(array(), array('id' => 'DESC'));
    }

    public function findById($id)
    {
        return $this->photos->find($id);
    }

    public function remove($id)
    {
        $this->photos->delete($this->findById($id));
    }
}