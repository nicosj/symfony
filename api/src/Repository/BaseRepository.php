<?php
namespace App\Repository;

use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectRepository;



abstract class BaseRepository
{
    private ManagerRegistry $managerRegistry;
    protected Connection $connection;
    protected ObjectRepository $objectRepository;

    public function __construct(ManagerRegistry $managerRegistry, Connection $connection )
    {
        $this->managerRegistry = $managerRegistry;
        $this->connection = $connection;
        $this->objectRepository= $this->getEntityManager()->getRepository($this->entityClass());
    }

    abstract protected static function entityClass(): string;

    /**
     * @param object $entity
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function persistEntity(object $entity):void
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function flusData():void{
        $this->getEntityManager()->flush();
        $this-$this->getEntityManager()->clear();
    }

    /**
     * @param object $entity
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveEntity(object $entity){
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param object $entity
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function  removeEntity(object $entity){
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    protected function executeFetchQuery(string $query, array $params=[]):array{
        return $this->connection->executeQuery($query,$params)->fetchAll();
    }
    protected function executeQuery(string $query, array $params=[]):void{
         $this->connection->executeQuery($query,$params)->fetchAll();
    }

    /**
     * @return ObjectManager | EntityManager
     */
    private function getEntityManager(){
        $entityManager= $this->managerRegistry->getManager();
        if($entityManager->isOpen()){
            return $entityManager;
        }
        return $this->managerRegistry->resetManager();
    }
}