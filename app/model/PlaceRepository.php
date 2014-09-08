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

class PlaceRepository extends Nette\Object {

    private $places;
    private $tracks;
    private $events;

    public function __construct(EntityDao $places, EntityDao $tracks, EntityDao $events)
    {
        $this->places = $places;
        $this->tracks = $tracks;
        $this->events = $events;
    }

    public function save($place)
    {
        $this->places->save($place);
    }

    public function remove($id)
    {
        $this->places->delete($this->findById($id));
    }

    public function findAll()
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->orderBy('e.name', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findAllCount()
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Place', 'e');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findById($id)
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findByFilters($values)
    {
        if(FilterUtils::arrayContainsOrEmpty('Places', $values['filterCategory']) == true && $values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->places->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Place', 'e');
            if($values['filterEntity'] == 'Event') {
                $subqb = $this->events->createQueryBuilder();
                $subqb
                    ->select('e')
                    ->from('App\Model\Event', 'e')
                    ->where('e.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
                $event = $subqb->getQuery()->getOneOrNullResult();

                $places = array();
                foreach ($event->eventPhotos as $photo) {
                    if($photo->place != NULL && FilterUtils::arrayContains($photo->place, $places) != true) {
                        $places[] = $photo->place;
                    }
                }
                if(FilterUtils::arrayContains($event->place, $places) != true) {
                    $places[] = $event->place;
                }
                if($event->placeTo != NULL && FilterUtils::arrayContains($event->placeTo, $places) != true) {
                    $places[] = $event->placeTo;
                }
                return $places;
            } elseif($values['filterEntity'] == 'Track') {
                $subqb = $this->tracks->createQueryBuilder();
                $subqb
                    ->select('e')
                    ->from('App\Model\Track', 'e')
                    ->where('e.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
                $event = $subqb->getQuery()->getOneOrNullResult();

                $places = array();
                foreach ($event->photos as $photo) {
                    if($photo->place != NULL && FilterUtils::arrayContains($photo->place, $places) != true) {
                        $places[] = $photo->place;
                    }
                }
                if(FilterUtils::arrayContains($event->place, $places) != true) {
                    $places[] = $event->place;
                }
                if($event->placeTo != NULL && FilterUtils::arrayContains($event->placeTo, $places) != true) {
                    $places[] = $event->placeTo;
                }
                return $places;
            } elseif($values['filterEntity'] == 'Place') {
                $subqb = $this->tracks->createQueryBuilder();
                $subqb
                    ->select('e')
                    ->from('App\Model\Track', 'e')
                    ->leftJoin('e.place', 'a')
                    ->leftJoin('e.placeTo', 'b')
                    ->where('a.id = :id')
                    ->setParameter('id', $values['filterEntityId'])
                    ->orderBy('b.name', 'ASC');
                $places = array();
                foreach($subqb->getQuery()->getResult() as $track) {
                    if(FilterUtils::arrayContains($track->placeTo, $places) != true) {
                        $places[] = $track->placeTo;
                    }
                }
                return $places;
            }
            if($values['search'] != '') {
                $qb
                    ->where($qb->expr()->like('e.name', ':name'))
                    ->setParameter('name', '%' . $values['search'] . '%');
            }
            $qb
                ->orderBy('e.name', 'DESC');

            return $qb->getQuery()->getResult();
        } elseif(FilterUtils::arrayContainsOrEmpty('Places', $values['filterCategory']) == true) {
            $qb = $this->places->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Place', 'e');

            if($values['search'] != '') {
                $qb
                    ->where($qb->expr()->like('e.name', ':name'))
                    ->setParameter('name', '%' . $values['search'] . '%');
            }
            $qb
                ->orderBy('e.name', 'ASC');
            if(empty($values['filterTransport']) != true) {
                $qb
                    //track
                    ->leftJoin('e.tracks', 'b')
                    ->where('b IS NOT NULL')
                    ->leftJoin('b.transport', 'g')
                    //event
                    ->leftJoin('e.events', 'o')
                    ->where('o IS NOT NULL')
                    ->leftJoin('o.transport', 'p')

                    ->where('g.name IN (:transports)')
                    ->orWhere('p.name IN (:transports)')
                    ->setParameter('transports', $values['filterTransport']);
            }
            return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }

    public function findByFiltersCount($values)
    {
        if ($values['filterEntity'] != '' && $values['filterEntityId'] != '') {
            $qb = $this->places->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Place', 'e');
            if($values['filterEntity'] == 'Event') {
                $subqb = $this->events->createQueryBuilder();
                $subqb
                    ->select('e')
                    ->from('App\Model\Event', 'e')
                    ->where('e.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
                $event = $subqb->getQuery()->getOneOrNullResult();

                $places = array();
                foreach ($event->eventPhotos as $photo) {
                    if($photo->place != NULL && FilterUtils::arrayContains($photo->place, $places) != true) {
                        $places[] = $photo->place;
                    }
                }
                if(FilterUtils::arrayContains($event->place, $places) != true) {
                    $places[] = $event->place;
                }
                if($event->placeTo != NULL && FilterUtils::arrayContains($event->placeTo, $places) != true) {
                    $places[] = $event->placeTo;
                }
                return count($places);
            } elseif($values['filterEntity'] == 'Track') {
                $subqb = $this->events->createQueryBuilder();
                $subqb
                    ->select('e')
                    ->from('App\Model\Track', 'e')
                    ->where('e.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
                $event = $subqb->getQuery()->getOneOrNullResult();

                $places = array();
                foreach ($event->photos as $photo) {
                    if($photo->place != NULL && FilterUtils::arrayContains($photo->place, $places) != true) {
                        $places[] = $photo->place;
                    }
                }
                if(FilterUtils::arrayContains($event->place, $places) != true) {
                    $places[] = $event->place;
                }
                if($event->placeTo != NULL && FilterUtils::arrayContains($event->placeTo, $places) != true) {
                    $places[] = $event->placeTo;
                }
                return count($places);
            } elseif($values['filterEntity'] == 'Place') {
                $subqb = $this->tracks->createQueryBuilder();
                $subqb
                    ->select('e')
                    ->from('App\Model\Track', 'e')
                    ->leftJoin('e.place', 'a')
                    ->where('a.id = :id')
                    ->setParameter('id', $values['filterEntityId']);
                $places = array();
                foreach($subqb->getQuery()->getResult() as $track) {
                    if(FilterUtils::arrayContains($track->placeTo, $places) != true) {
                        $places[] = $track->placeTo;
                    }
                }
                return count($places);
            }
            return $qb->getQuery()->getSingleScalarResult();
        } else {
            $qb = $this->places->createQueryBuilder();
            $qb
                ->select('COUNT(e.id)')
                ->from('App\Model\Place', 'e');

            if($values['search'] != '') {
                $qb
                    ->where($qb->expr()->like('e.name', ':name'))
                    ->setParameter('name', '%' . $values['search'] . '%');
            }
            if(empty($values['filterTransport']) != true) {
                $qb
                    //track
                    ->leftJoin('e.tracks', 'b')
                    ->where('b IS NOT NULL')
                    ->leftJoin('b.transport', 'g')
                    //event
                    ->leftJoin('e.events', 'o')
                    ->where('o IS NOT NULL')
                    ->leftJoin('o.transport', 'p')

                    ->where('g.name IN (:transports)')
                    ->orWhere('p.name IN (:transports)')
                    ->setParameter('transports', $values['filterTransport']);
            }
            return $qb->getQuery()->getSingleScalarResult();
        }
    }
}