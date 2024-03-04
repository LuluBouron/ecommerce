<?php

namespace App\EventListener;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsDoctrineListener(event: Events::postRemove, priority: 500, connection: 'default')]
class DatabaseActivityListener
{

     /** KernelInterface $appKernel */
     private $appKernel;
     private $rootDir;
 
     public function __construct(KernelInterface $appKernel)
     {
         $this->appKernel = $appKernel;
         $this->rootDir = $appKernel->getProjectDir();
     }
    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    // public function postPersist(PostPersistEventArgs $args): void
    // {

    //     $entity = $args->getObject();

    //     // if this listener only applies to certain entity types,
    //     // add some code to check the entity type as early as possible
    //     if (!$entity instanceof Product) {
    //         return;
    //     }

    //     $entityManager = $args->getObjectManager();
    //     // ... do something with the Product entity
    // }


    public function postRemove(PostRemoveEventArgs $args): void 
    {
        // dd($args);
        $this->logActivity('remove', $args->getObject());
    }

    public function logActivity(string $action, mixed $entity): void 
    {
      
        if(($entity instanceof Product) && $action === "remove"){
           
            // remove image

            $imageUrls = $entity->getImageUrls();
            
            foreach ($imageUrls as $imageUrl) {
                $filelink = $this->rootDir. "/public/assets/images/products/".$imageUrl;
               //dd($filelink);
                $this->deleteImage($filelink);
            // dd($filelink);
            }

        }
        if(($entity instanceof Category) && $action === "remove"){
            // remove image
            $filename = $entity->getImageUrls();

            $filelink = $this->rootDir. "/public/assets/images/categories/".$filename;

            $this->deleteImage($filelink);

            
        }
        
    }
    
    public function deleteImage(string $filelink): void
    {
        try {
            //code...
            $result = unlink($filelink);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


   
}