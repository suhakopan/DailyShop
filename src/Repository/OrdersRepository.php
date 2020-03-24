<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function getOrderDetail($orderid):array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT od.id,p.Title,p.Price,od.Quantity,(p.Price*od.Quantity) as toplam,o.Total,o.status FROM App\Entity\Orders o,App\Entity\OrderDetail od,App\Entity\Admin\Product p WHERE o.id=od.OrderID and od.ProductID=p.id and od.OrderID=:orderid')->setParameter('orderid',$orderid);
        return $query->getResult();

    }
    // /**
    //  * @return Orders[] Returns an array of Orders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Orders
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
