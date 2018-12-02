<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 31.10.18
 * Time: 0:36
 */

namespace App\services;

use App\entities\Notice;
use App\entities\User;

class ValidationService
{

    private $notice;

    public function __construct()
    {
        $this->notice = new Notice();
    }


    public function checkEmail($email){

        if (!strlen($email)) {
          $this->notice->setEmailError('You must enter mail');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $this->notice->setEmailError("Invalid email format");
        }
    }

    public function checkPassword($password){
        if (!strlen($password)) {
           $this->notice->setPasswordError('You must enter password');
        } elseif (strlen($password) < 8) {
           $this->notice->setPasswordError("Length of password must be greater than 8 symbols");
        }
    }


    public function checkConfirmPassword($confirmPassword, $password){
        if (!strlen(($confirmPassword))) {
            $this->notice->setConfirmPasswordError('You must enter confirm-password');
        } elseif (password_verify($confirmPassword, $password)) {
            $this->notice->setConfirmPasswordError('Confirm password must be the same as password');
        }
    }

    public function checkDate($dateOfBirth){
        if (empty($dateOfBirth)) {
            $this->notice->setDateError('You must enter your birthday');
        } /*elseif (!filter_var($dateOfBirth, FILTER_VALIDATE_REGEXP, ['options' =>
            ['regexp' => '/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/']])) {
            $this->notice->setDateOfBirth('Date of birth has incorrect format');
        }*/
    }

    public function checkUser($data){
        $this->checkEmail($data['email']);
        $this->checkDate($data['date_of_birth']);
        $this->checkPassword($data['password']);
        $this->checkConfirmPassword($data['confirm_password'], $data['password']);
    }

    public function checkUpdatedPassword(string $password, string $oldPassword){
        if ($password !== $oldPassword){
            $this->notice->setPasswordError('You entered the wrong password');
        }
    }
    /**
     * @return Notice
     */
    public function getNotice(): Notice
    {
        return $this->notice;
    }

}