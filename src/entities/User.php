<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 30.10.18
 * Time: 16:25
 */

namespace App\entities;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="public.users")
 */
class User
{

    // add roles (user/ admin)
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    public $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    public $password;

    /**
     * @ORM\Column(type="string")
     */
    public $date_of_birth;

    /**
     * @ORM\Column(type="string", length=10)
     */
    public $gender;

    /**
     * @ORM\Column(type="boolean")
     */
    public $mailing; //?

    /**
     * @ORM\Column(type="string")
     */
    public $country;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }


    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param \DateTime $date_of_birth
     */
    public function setDateOfBirth($date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return boolean
     */
    public function getMailing()
    {
        return $this->mailing;
    }

    /**
     * @param boolean $mailing
     */
    public function setMailing($mailing): void
    {
        $this->mailing = $mailing;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

}