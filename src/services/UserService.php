<?php

namespace App\services;

use App\entities\User;
use App\repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $userRepository;
    private $user;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->userRepository = new UserRepository($entityManager);
        $this->user = new User();
    }

    function fillUser(User $user)
    {
        isset($_POST["email"]) ? $user->setEmail($_POST['email']) : $user->setEmail('');
        isset($_POST["password"]) ? $user->setPassword($_POST['password']) : $user->setPassword('');
        isset($_POST["country"]) ? $user->setCountry($_POST["country"]) : $user->setCountry('');
        isset($_POST['date-of-birth']) ? $user->setDateOfBirth(new \DateTime($_POST["date-of-birth"])) : $user->setDateOfBirth(null);
        isset($_POST['country']) ? $user->setCountry($_POST["country"]) : $user-> setCountry('');
        isset($_POST['gender'])? $user->setGender($_POST["gender"]) : $user->setGender('');
        isset($_POST['mailing']) ? $user->setMailing($_POST["mailing"]) : $user->setMailing(false);

        return $user;
    }

    function findUserByEmailAndPswd(string $email, string $password){
       return $this->userRepository->findUserByEmailAndPassword($email, $password );
    }
    /*function createUser(User $user){
        $array = get_object_vars($user);
        $values = [];
        foreach ($array as $value){
            array_push($values, $value);
        }
    }*/

    function findUser(int $id){

    }

    function deleteUser(User $user){

    }

    function updateUser(User $user){

    }

}