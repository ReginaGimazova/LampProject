<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 14.11.18
 * Time: 14:19
 */

namespace App\repositories;


use App\entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;

class UserRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function findUserByEmail(string $email)
    {
       return $this->repository->find($email);
    }

    public function findUserById(int $id)
    {
        return $this->repository->find($id);
    }

    public function findUserByEmailAndPassword(string $email, string $password)
    {
        try {
            return $this->repository->createQueryBuilder('u')
                ->where('u.email = :email AND u.password = :password')
                ->setParameter('email', $email)
                ->setParameter('password', $password)
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_SCALAR);
        } catch (NonUniqueResultException $e) {
        }
    }

}


