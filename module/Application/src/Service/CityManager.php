<?php
namespace Application\Service;

use Application\Entity\City;
use Zend\Filter\StaticFilter;

class CityManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Конструктор, используемый для внедрения зависимостей в сервис.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateCity($city, $data)
    {
        $city->setName($data['name']);

        // Применяем изменения к базе данных.
        return $this->entityManager->flush();
    }
}