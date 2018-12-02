<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 06.11.18
 * Time: 22:45
 */

namespace App\entities;


class Notice
{
    public $emailError;
    public $passwordError;
    public $confirmPasswordError;
    public $dateError;

    /**
     * @return mixed
     */
    public function getEmailError()
    {
        return $this->emailError;
    }

    /**
     * @param mixed $emailError
     */
    public function setEmailError($emailError): void
    {
        $this->emailError = $emailError;
    }

    /**
     * @return mixed
     */
    public function getPasswordError()
    {
        return $this->passwordError;
    }

    /**
     * @param mixed $passwordError
     */
    public function setPasswordError($passwordError): void
    {
        $this->passwordError = $passwordError;
    }

    /**
     * @return mixed
     */
    public function getConfirmPasswordError()
    {
        return $this->confirmPasswordError;
    }

    /**
     * @param mixed $confirmPasswordError
     */
    public function setConfirmPasswordError($confirmPasswordError): void
    {
        $this->confirmPasswordError = $confirmPasswordError;
    }

    /**
     * @return mixed
     */
    public function getDateError()
    {
        return $this->dateError;
    }

    /**
     * @param mixed $dateError
     */
    public function setDateError($dateError): void
    {
        $this->dateError = $dateError;
    }

    public function __toString()
    {
        return $this->getEmailError(). ''. $this->getPasswordError(). ''. $this->getConfirmPasswordError(). ''. $this->getDateError();
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }


}