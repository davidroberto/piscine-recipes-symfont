<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }



    public function findBySearchInTitle(string $search): array {

        $queryBuilder = $this->createQueryBuilder('recipe');

        $query = $queryBuilder->select('recipe')
                    ->where('recipe.title LIKE :search')
                    ->setParameter('search', '%' . $search .'%' )
                    ->getQuery();

        return $query->getResult();
    }
}
