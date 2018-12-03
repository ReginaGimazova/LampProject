<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 31.10.18
 * Time: 0:36
 */

namespace App\services;
use App\entities\User;

class ValidationService
{

    private $notices = [
        "emailError" => "",
        "passwordError" => "",
        "repeatPasswordError" => "",
        "dateError" => "",
        "updatedPasswordError" => ""
    ];

    public function checkEmail($email){

        if (!strlen($email)) {
          $this->notices["emailError"] = 'You must enter mail';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $this->notices["emailError"] = "Invalid email format";
        }
    }

    public function checkPassword($password){
        if (!strlen($password)) {
           $this->notices["passwordError"] = 'You must enter password';
        } elseif (strlen($password) < 8) {
           $this->notices["passwordError"] = "Length of password must be greater than 8 symbols";
        }
    }


    public function checkConfirmPassword($repeatPassword, $password){
        if (!strlen(($repeatPassword))) {
            $this->notices["repeatPasswordError"] = 'You must enter confirm-password';
        } elseif (password_verify($repeatPassword, $password)) {
            $this->notices["repeatPasswordError"] = 'Confirm password must be the same as password';
        }
    }

    public function checkDate($dateOfBirth){
        if (empty($dateOfBirth)) {
            $this->notices["dateError"] = 'You must enter your birthday';
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
            $this->notices["updatedPasswordError"] = 'You entered the wrong password';
        }
    }
    /**
     * @return array
     */
    public function getNotices(): array
    {
        return $this->notices;
    }

}