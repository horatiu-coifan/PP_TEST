<?php

namespace App\DataFixtures;

use App\Entity\Transactions;
use App\Entity\Clients;
use App\Entity\County;
use App\Entity\Login;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // $manager->flush();

        // Add counties
        $this -> addCounty($manager, "Bucuresti");
        $this -> addCounty($manager, "Ilfov");
        $this -> addCounty($manager, "Brasov");
        $this -> addCounty($manager, "Cluj");
        $this -> addCounty($manager, "Constanta");
        $this -> addCounty($manager, "Timisoara");
        $this -> addCounty($manager, "Iasi");

        // Add credentials
        $this -> addCredentials($manager,  'admin', 'admin', 'A', 'admin');
        $this -> addCredentials($manager,  'user1', 'pass1', 'A', 'user');
        $this -> addCredentials($manager,  'user2', 'pass2', 'A', 'user');
        $this -> addCredentials($manager,  'user3', 'pass3', 'A', 'user');
    }

    protected function addCredentials(
            ObjectManager &$manager, 
            string $username, 
            string $password, 
            string $status,
            string $type
        ): void{
        try{
            $login = new Login();
            $login
                -> setUsername($username)
                -> setStatus($status)
                -> setPassword(md5($password))
                -> setType($type)
            ;
            $manager -> persist($login);
            $manager -> flush();
        }
        catch( Exception $exception){
            throw new \ErrorException("Cannot insert credentials");
        }
    }

    protected function addCounty(
        ObjectManager &$manager, 
        string $name
    ): County{
        try{
            $county = new County();
            $county -> setName($name);
            $manager -> persist($county);
            $manager -> flush();

            return $county;
        }
        catch( Exception $exception){
            throw new \ErrorException("Cannot insert county");
        }
    }
}
