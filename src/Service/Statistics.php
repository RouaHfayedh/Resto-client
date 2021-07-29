<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class Statistics{

    public function __construct(ObjectManager $manager){

        $this->manager = $manager;

    }

    public function getStatistics(){

        $users = $this->getUsersCount();
        $ads = $this->getAdsCount();
        $books = $this->getBooksCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentsCount();

        return compact('users','ads','books','bookings','comments');

    }

    public function getUsersCount(){

        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();

    }

    public function getAdsCount(){

        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')->getSingleScalarResult();

    }

    public function getBookingsCount(){

        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();

    }

    public function getBooksCount(){

        return $this->manager->createQuery('SELECT COUNT(o) FROM App\Entity\Book o')->getSingleScalarResult();

    }

    public function getCommentsCount(){

        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comments c')->getSingleScalarResult();

    }

    public function getAdsStats($direction){

        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note,a.title,a.id
            FROM app\Entity\Comments c
            JOIN c.ad a
            GROUP BY a
            ORDER BY note '.$direction)
            ->setMaxResults(6)
            ->getResult();

    }
    
}