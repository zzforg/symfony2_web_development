<?php

namespace Ibase\StoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{   
    public function findByCategory($category_id = null)
    {
        $qb = $this->createQueryBuilder('p');
        // when category is specified
        if ($category_id){
        $qb->where('p.category = :category_id')
        ->setParameter('category_id', $category_id);
        }
        $query = $qb->getQuery();
 
        return $query->getResult();
    }
    
    public function findTopSaleProducts($num = null)
    {
        $num = 10;
       // $qb = $this->createQueryBuilder('s');
//        $subqb = $this->createQueryBuilder('p');
//        // when category is specified
//        //if ($num){
//        $subqb->select('p, '. $subqb->expr()->count(1).' As count' )
//              ->from('IbaseStoreBundle:Product', 'p')
//           ->innerJoin('IbaseStoreBundle:PurchasePerItem', 'ppi','WITH', $subqb->expr()->eq('p.id','ppi.product'))
//           ->groupBy('p.id');
//          // ->orderBy($qb->expr()->count('1'), 'DESC')
//          // ->setMaxResults($num);
//        $qb ->select('s.p')
//            ->from($subqb->getDQL(),'s')
//            ->orderBy('s.count', 'DESC')
//            ->setMaxResults($num);        
 //       exit($qb->getQuery()->getSQL());
//        ->setParameter('category_id', $category_id);
        $rsm = new ResultSetMapping();
        $query = $this->getEntityManager()->createNativeQuery(
        'SELECT s.p FROM (SELECT p, count(1) as count '
                . 'FROM IbaseStoreBundle:Product p '
                . 'INNER JOIN IbaseStoreBundle:PurchasePerItem ppi '
                . 'ON p.id = ppi.product_id '
                . 'GROUP BY p.id) AS s ORDER BY s.count DESC'
                , $rsm);
        //}
        //$query = $qb->getQuery();
 
        return $query->getResult();
    }
}
