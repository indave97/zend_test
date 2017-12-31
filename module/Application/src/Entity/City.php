<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Application\Repository\CityRepository")
 * @ORM\Table(name="city")
 */

class City{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ID")
     */
    protected $ID;
    /**
     * @ORM\Column(name="Name")
     */
    protected $Name;
    /**
     * @ORM\Column(name="CountryCode")
     */
    protected $CountryCode;
    /**
     * @ORM\Column(name="District")
     */
    protected $District;
    /**
     * @ORM\Column(name="Population")
     */
    protected $Population;
    /**
    * @ORM\ManyToOne(targetEntity="\Application\Entity\Country", inversedBy="cities")
    * @ORM\JoinColumn(name="CountryCode", referencedColumnName="Code")
    */
    protected $country;


    public function exchangeArray(array $data){
        $this->ID = $data['ID'];
        $this->Name = $data['Name'];
        $this->CountryCode = $data['CountryCode'];
        $this->District = $data['District'];
        $this->Population = $data['Population'];
    }

    public function getId(){
        return $this->ID;
    }

    public function getName(){
        return $this->Name;
    }

    public function setName($name){
        $this->Name = $name;
    }

    public function getCountryCode(){
        return $this->CountryCode;
    }

    public function getDistrict(){
        return $this->District;
    }

    public function getPopulation(){
        return $this->Population;
    }

    /*
     * @return \Application\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

}