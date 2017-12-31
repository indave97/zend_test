<?php
/**
 * Created by PhpStorm.
 * User: Vadym
 * Date: 30.12.2017
 * Time: 17:52
 */

namespace Application\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="country")
 */

class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="Code")
     */
    protected $Code;
    /**
     * @ORM\Column(name="Name")
     */
    protected $Name;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\City", mappedBy="country")
     * @ORM\JoinColumn(name="Code", referencedColumnName="CountryCode")
     */
    protected $cities;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\CountryLanguage", mappedBy="country")
     * @ORM\JoinColumn(name="Code", referencedColumnName="CountryCode")
     */
    protected $languages;


    public function __construct()
    {
        $this->cities = new ArrayCollection();
        $this->languages = new ArrayCollection();
    }

    public function getCode(){
        return $this->Code;
    }

    public function getName(){
        return $this->Name;
    }
    /**
     * @return array
     */
    public function getCities()
    {
        return $this->cities;
    }
    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

}