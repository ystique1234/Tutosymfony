<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    //    /**
    //     * @return Recipe[] Returns an array of Recipe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recipe
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


     /**
    * @return Recipe[] 
    */
       public function findRecipeDurationLowerThan(int $duration): array
       {
           return $this->createQueryBuilder('r')
               ->Where('r.duration <= :duration')
               ->orderBy('r.duration', 'ASC')
               ->setMaxResults(10)
               ->setParameter('duration', $duration)
               ->getQuery()
               ->getResult();
       }

      //methode permettant de trouver une recette dans la barre de recherche
    public function findBySearch(SearchData $searchData)
    {
        $data = $this->createQueryBuilder('r')
            ->addOrderBy('r.createdAt', 'DESC');
        if (!empty($searchData->query)) {
            $data = $data
                //recherche que sur le titre
                ->andWhere('r.title LIKE :query')
                //Si on veut rajouter aussi la recherche dans le contenu
                // ->orWhere('r.content LIKE :query')
                ->setParameter('query', "%{$searchData->query}%");
        }
        return $data
            ->getQuery();
            // ->getResult();
    }
 }
