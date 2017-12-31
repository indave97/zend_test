<?php
/**
 * Created by PhpStorm.
 * User: Vadym
 * Date: 30.12.2017
 * Time: 18:09
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="countrylanguage")
 */
class CountryLanguage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ID")
     */
    protected $ID;
    /**
     * @ORM\Column(name="CountryCode")
     */
    protected $CountryCode;
    /**
     * @ORM\Column(name="Language")
     */
    protected $Language;
    /**
     * @ORM\Column(name="IsOfficial")
     */
    protected $IsOfficial;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Country", inversedBy="languages")
     * @ORM\JoinColumn(name="CountryCode", referencedColumnName="Code")
     */
    protected $country;

    public function getId(){
        return $this->ID;
    }

    public function getCountryCode(){
        return $this->CountryCode;
    }

    public function getLanguage(){
        return $this->Language;
    }

    public function getOfficial(){
        return $this->IsOfficial;
    }
    /*
     * @return \Application\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

}