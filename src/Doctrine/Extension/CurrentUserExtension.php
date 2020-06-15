<?php

namespace App\Doctrine\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use App\Entity\Customer;
use App\Entity\Invoice;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function applyToItem(\Doctrine\ORM\QueryBuilder $queryBuilder, \ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        if ($resourceClass === Customer::class) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
                ->andWhere($rootAlias . '.user = :user')
                ->setParameter('user', $this->security->getUser());
        }

        if ($resourceClass === Invoice::class) {
            $alias = $queryNameGenerator->generateJoinAlias('customer');
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
                ->join($rootAlias . '.customer', $alias)
                ->andWhere($alias . '.user = :user')
                ->setParameter('user', $this->security->getUser());
        }
    }

    public function applyToCollection(\Doctrine\ORM\QueryBuilder $queryBuilder, \ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {
        if ($resourceClass === Customer::class) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
                ->andWhere($rootAlias . '.user = :user')
                ->setParameter('user', $this->security->getUser());
        }


        if ($resourceClass === Invoice::class) {
            $alias = $queryNameGenerator->generateJoinAlias('customer');
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
                ->join($rootAlias . '.customer', $alias)
                ->andWhere($alias . '.user = :user')
                ->setParameter('user', $this->security->getUser());
        }
    }








    // protected function filterByUser(string $rootAlias, \Doctrine\ORM\QueryBuilder $queryBuilder)
    // {
    //     $rootAlias = $queryBuilder->getRootAliases()[0];
    //     $queryBuilder
    //         ->andWhere($rootAlias . '.user = :user')
    //         ->setParameter('user', $this->security->getUser());
    // }
}
