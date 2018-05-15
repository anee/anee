<?php

namespace App\Model;




/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackBaseLogic extends BaseLogic {


    public function remove($id)
    {
        $this->dao->delete($this->findOneById($id));
    }

    public function findAll()
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findLast($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    public function findAllCount($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Track', 'e');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getSingleScalarResult();
    }

    public function findLastByCount($count, $userId)
    {
        $results = [];
        $counter = 0;
        foreach($this->findAllByUserId($userId) as $track) {
            if($counter < $count) {
                $results[] = $track;
            } else {
                break;
            }
            $counter++;
        }
        return $results;
    }

    public function findAllByUserId($userId)
    {
        $profileTracks = [];
        foreach ($this->findAll() as $track) {
            /** @var $track Track */
            if ($track->getUser()->getId() == $userId) {
                $profileTracks[] = $track;
            } else {
                foreach ($track->getWithUsers() as $user) {
                    /** @var $user User */
                    if ($user->getId() == $userId) {
                        $profileTracks[] = $track;
                    }
                }
            }
        }
        return $profileTracks;
    }

    public function getTotalDistance($tracks)
    {
        $distance = 0;
        foreach($tracks as $track) {
            $distance += $track->distance;
        }
        return round($distance);
    }

	public function findLastPinnedByCount($count, $userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e')
			->where('e.pinned = TRUE')
			->orderBy('e.date', 'DESC');

		return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults($count)->getResult();
	}

	public function findAllPinnedByUserId($userId)
	{
        $pinnedTracks = [];
        foreach($this->findAllByUserId($userId) as $track) {
            if($track->isPinned()) {
                $pinnedTracks[] = $track;
            }
        }
        return $pinnedTracks;
	}

	public function findAllUnpinnedByUserId($userId)
	{
        $pinnedTracks = [];
        foreach($this->findAllByUserId($userId) as $track) {
            if(!$track->isPinned()) {
                $pinnedTracks[] = $track;
            }
        }
        return $pinnedTracks;
	}

	public function findOneById($id)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAllByUserIdAndPlaceAndYear($userId, Place $place, $year = NULL)
    {
        $results = [];
        foreach($this->findAllByUserId($userId) as $track) {
            if($track->getPlace()->getName() == $place->getName()) {
              if($year == NULL || $year == $track->date->format('Y')) {
                $results[] = $track;
              }
            }
        }
        return $results;
    }

	public function findOneByIdAndUserId($id, $userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e')
			->andWhere('e.id = :id')
			->setParameter('id', $id)
			->orderBy('e.date', 'DESC');

		return $this->addFilterByUser($qb, $userId)->getQuery()->getOneOrNullResult();
	}

	public function findOneByIdAndUsername($id, $username)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e')
			->andWhere('e.id = :id')
			->setParameter('id', $id);

		return $this->addFilterByUserName($qb, $username)->getQuery()->getOneOrNullResult();
	}

	public function findOneByIdAndUsernameUrl($id, $username)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e')
			->andWhere('e.id = :id')
			->setParameter('id', $id);

		return $this->addFilterByUserNameUrl($qb, $username)->getQuery()->getOneOrNullResult();
	}

	public function distanceSum($userId)
  {
    $distance = 0;
    foreach ($this->findAll($userId) as $track) {
      $distance += $track->getDistance();
    }
    return $distance;
  }

  public function findAllPerYears($userId)
  {
    $distinctsYears = array();
    $tracks = $this->findAllByUserId($userId);
    foreach($tracks as $track) {
      $date = $track->date->format('Y');
      if(!array_key_exists($date, $distinctsYears)) {
        $distinctsYears[$date][] = $track;
      } else {
        $distinctsYears[$date][] = $track;
      }
    }
    return $distinctsYears;
  }

  public function findAllYears($userId)
  {
    $distinctsYears = array();
    $tracks = $this->findAllByUserId($userId);
    foreach($tracks as $track) {
      $date = $track->date->format('Y');
      if(!array_key_exists($date, $distinctsYears)) {
        $distinctsYears["Year $date"] = "Year $date";
      }
    }
    return $distinctsYears;
  }
}
