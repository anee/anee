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
use App\Utils\FilterUtils;


class TrackRepository extends Nette\Object {

    private $tracks;

    public function __construct(EntityDao $dao)
    {
        $this->tracks = $dao;
    }

    public function save($track)
    {
        $this->tracks->save($track);
    }

    public function findAll()
    {
        return $this->tracks->findBy(array(), array('id' => 'DESC'));
    }

    public function findLast()
    {
        return $this->tracks->findOneBy(array(), array('id' => 'DESC'), 1);
    }

    public function findBeforeLast()
    {
        $counter = 0;
        $tracks = $this->tracks->findBy(array(), array('id' => 'DESC'), 2);

        foreach($tracks as $track) {
            if ($counter == 0) {
                $counter ++;
            } else {
                return $track;
            }
        }
        return NULL;
    }

    public function findById($id)
    {
        return $this->tracks->find($id);
    }

    public function remove($id)
    {
        $this->tracks->delete($this->findById($id));
    }

    public function distanceSum()
    {
        $distance = 0;
        foreach ($this->findAll() as $track) {
            $distance += $track->getDistance();
        }
        return $distance;
    }

    public function findByFilters($values)
    {
        if($values['filterCategory'] == 'Tracks' || $values['filterCategory'] == '') {

            $qb = $this->tracks->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Track', 'e');

            if($values['search'] != '') {
                $qb
                    ->where($qb->expr()->like('e.from', ':search'))
                    ->orWhere($qb->expr()->like('e.to', ':search'))
                    ->setParameter('search', '%' . $values['search'] . '%');
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
            }
            if($values['filterTransport'] != '') {
                $qb
                    ->andWhere('e.transport >= :transport')
                    ->setParameter('transport', $values['filterTransport']);
            }
            $qb
                ->orderBy('e.id', 'DESC');

            return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }
}