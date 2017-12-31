<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\City;
use Application\Entity\Country;
use Application\Entity\CountryLanguage;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $cityManager;

    public function __construct($entityManager, $cityManager)
    {
        $this->entityManager = $entityManager;
        $this->cityManager = $cityManager;
    }

    public function indexAction()
    {

        $page = $this->params()->fromQuery('page', 1);

        $get = $this->params()->fromQuery();
        $query = $this->entityManager->getRepository(City::class)
            ->findCities($get);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);



        return new ViewModel([
            'cities' => $paginator,
            'get' => $get
        ]);
    }

    public function editAction()
    {
        $viewmodel = new ViewModel();
        $cityId = $this->params()->fromPost('id', -1);
        $request = $this->getRequest();

        // Находим существующий пост в базе данных.
        $city = $this->entityManager->getRepository(City::class)
            ->findOneBy(['ID' => $cityId]);
        if ($city == null) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }
        $viewmodel->setTerminal($request->isXmlHttpRequest());

        if($request->isXmlHttpRequest()){
            $data = $this->params()->fromPost();

            $this->cityManager->updateCity($city, $data);

            $result = 1;
        } else {
            $this->getResponse()->setStatusCode(404);
            $result = 0;
        }

        $viewmodel->setVariables(array(

            'result' => $result
        ));

        return $viewmodel;
    }

    public function filterAction(){
        $viewmodel = new ViewModel();
        $filter = $this->params()->fromPost();
        $request = $this->getRequest();

        $viewmodel->setTerminal($request->isXmlHttpRequest());

        $get = $this->params()->fromQuery();
        $query = $this->entityManager->getRepository(City::class)
            ->findCities($get, $filter);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(100);
        $paginator->setCurrentPageNumber(1);

        $viewmodel->setVariables(array(
            'cities' => $paginator
        ));

        return $viewmodel;
    }
}
