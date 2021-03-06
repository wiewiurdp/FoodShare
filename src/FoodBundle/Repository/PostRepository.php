<?php

namespace FoodBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FoodBundle\Entity\Post;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    public function findAllFilteredOrdered($order, $direction)
    {

        $order = "p." . $order;
        $em = $this->getEntityManager();
        $gb = $em->createQueryBuilder()
            ->select('p')
            ->from('FoodBundle:Post', 'p')
            ->where('p.portions > 0 and p.expiration> :time')
            ->orderBy($order, $direction)
            ->setParameter('time', date('Y-m-d H:i:s'));

        $query = $gb->getQuery();
        return $query->getResult();

    }

    public function findSearchedOrdered($order, $direction, Post $post)
    {

        $order = "p." . $order;
        $em = $this->getEntityManager();
        $gb = $em->createQueryBuilder()
            ->select('p')
            ->from('FoodBundle:Post', 'p')
            ->where('p.portions > 0 and p.expiration> :time and p.expiration > :expiration')
            ->orderBy($order, $direction)
            ->setParameter('time', date('Y-m-d H:i:s'))
            ->setParameter('expiration', $post->getExpiration());

        if ($post->getCategory() != "dowolna") {
            $gb->andWhere('p.category = :category')
                ->setParameter('category', $post->getCategory());
        }

        if ($post->getSubCategory() != "dowolna") {
            $gb->andWhere('p.subCategory = :subCategory')
                ->setParameter('subCategory', $post->getSubCategory());
        }
        if ($post->getHotness() != "dowolna") {
            $gb->andWhere('p.hotness = :hotness')
                ->setParameter('hotness', $post->getHotness());
        }

        if ($post->getVegan() != "dowolna") {
            $gb->andWhere('p.vegan = :vegan')
                ->setParameter('vegan', $post->getVegan());
        }
        if ($post->getGluten() != "dowolna") {
            $gb->andWhere('p.gluten = :gluten')
                ->setParameter('gluten', $post->getGluten());
        }
        if (true) {
            $gb->innerJoin('p.ingredients', 'i')
                ->andWhere('i.name = :ingredient')
                ->andWhere('i.name = :ingredient2')
                ->setParameter('ingredient', "Cebula")
                ->setParameter('ingredient2', "Ziemniaki");
        }


        $query = $gb->getQuery();
//        var_dump($post->getIngredients());
        return $query->getResult();

    }
}
