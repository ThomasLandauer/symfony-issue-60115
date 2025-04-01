<?php declare(strict_types = 1);
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Logintoken;

/**
 * @extends ServiceEntityRepository<Logintoken>
 */
final class LogintokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logintoken::class);
    }

    public function findUserFromLogintoken(string $token): ?User
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->andWhere('l.token = :token')->setParameter('token', $token)
            ->andWhere('l.user IS NOT NULL')
        ;
        $logintoken = $queryBuilder->getQuery()->getOneOrNullResult();
        if ($logintoken instanceof Logintoken) {
            return $logintoken->getUser();
        }
        return null;
    }
}
