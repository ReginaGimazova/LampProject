<?php

namespace App\services;

use App\entities\User;
use App\repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PDO;

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

    function deleteUser(int $id){
        $pdoString = "pgsql:host=localhost;port=5432;dbname=db;user=postgres;password=34Zc18WfLn";

        try{
            $pdo = new PDO($pdoString);
        }
        catch (\PDOException $e){
            var_dump($e->getMessage());
        }
        $sql = "delete from users where id=:id";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}