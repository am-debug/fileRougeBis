<?php
namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;



class ProfilDataPersister implements DataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;
   

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;
       
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profils;
    }

    public function persist($data, array $context = [])
    {

        return $data;

    }

    public function remove($data, array $context = [])
    {
        $archive=$data->setArchived(true);
        $this->_entityManager->persist($archive);

        $users=$data->getUsers();
        foreach($users as $user){
           $a= $users->setArchived(true);
           
        }
        $this->_entityManager->persist($a);
        
        $this->_entityManager->flush();
    }
   

      
    
}