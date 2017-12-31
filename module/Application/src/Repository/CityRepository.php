<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\City;

class CityRepository extends EntityRepository
{

    public function findCities($get, array $filter = null){
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('c')
            ->from(City::class, 'c');

        foreach ($get as $key => $value) {
            switch ($key) {
                case 'ID':
                    $queryBuilder->orderBy('c.ID', $value);
                    break;
                case 'Name':
                    $queryBuilder->orderBy('c.Name', $value);
                    break;
                case 'CountryCode':
                    $queryBuilder->orderBy('c.CountryCode', $value);
                    break;
                case 'District':
                    $queryBuilder->orderBy('c.District', $value);
                    break;
                case 'Population':
                    $queryBuilder->orderBy('c.Population', $value);
                    break;
                case 'Country':
                    $queryBuilder
                        ->join('c.country', 't')
                        ->orderBy('t.Name', $value);
                    break;
            }
        }
        if($filter){
            foreach ($filter as $key => $value) {
                switch ($key) {
                    case 'ID':
                        if($value != ''){
                            $queryBuilder
                                ->andWhere('c.ID = ?1')
                                ->setParameter(1, $value);
                        }
                        break;
                    case 'Name':
                        $queryBuilder
                            ->andWhere($queryBuilder->expr()->like('c.Name', '?2'))
                            ->setParameter(2, '%'.$value.'%');
                        break;
                    case 'CountryCode':
                        $queryBuilder
                            ->andWhere($queryBuilder->expr()->like('c.CountryCode', '?3'))
                            ->setParameter(3, '%'.$value.'%');
                        break;
                    case 'District':
                        $queryBuilder
                            ->andWhere($queryBuilder->expr()->like('c.District', '?4'))
                            ->setParameter(4, '%'.$value.'%');
                        break;
                    case 'Population':
                        $queryBuilder
                            ->andWhere($queryBuilder->expr()->between('c.Population', '?5', '?6'))
                            ->setParameter(5, $value['min'])
                            ->setParameter(6, $value['max']);
                        break;
                    case 'Country':
                        $queryBuilder
                            ->join('c.country', 't')
                            ->andWhere($queryBuilder->expr()->like('t.Name', '?7'))
                            ->setParameter(7, '%'.$value.'%');
                        break;
                }
            }
        }


        return $queryBuilder->getQuery();
    }

}