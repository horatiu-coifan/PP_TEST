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
        $bucuresti = $this -> addCounty($manager, "Bucuresti");
        $ilfov = $this -> addCounty($manager, "Ilfov");
        $brasov = $this -> addCounty($manager, "Brasov");
        $cluj = $this -> addCounty($manager, "Cluj");
        $constanta = $this -> addCounty($manager, "Constanta");
        $timisoara = $this -> addCounty($manager, "Timisoara");

        // Add products
        $prod1 = $this -> addProduct( $manager, "Product 1", "Description Product 1");
        $prod2 = $this -> addProduct( $manager, "Product 2", "Description Product 2");
        $prod3 = $this -> addProduct( $manager, "Product 3", "Description Product 3");
        $prod4 = $this -> addProduct( $manager, "Product 4", "Description Product 4");
        $prod5 = $this -> addProduct( $manager, "Product 5", "Description Product 5");
        $prod6 = $this -> addProduct( $manager, "Product 6", "Description Product 6");
        $prod7 = $this -> addProduct( $manager, "Product 7", "Description Product 7");

        // Add clients
        $client1 = $this -> addClient($manager, 'RO 12345678', 'Client 1 SRL', 'Str. Virtutii Nr.12', 'Bucuresti', $bucuresti);
        $client2 = $this -> addClient($manager, 'RO 22233344', 'Client 2 SA', 'Str. Bunastarii Nr. 7', 'Bucuresti', $bucuresti);
        $client3 = $this -> addClient($manager, '98762345', 'Client 3 SRL', 'Str. Mihai Viteazul Nr. 10', 'Brasov', $brasov);

        // Add credentials
        $this -> addCredentials($manager, $client1, 'user1', 'pass1');
        $this -> addCredentials($manager, $client2, 'user2', 'pass2');
        $this -> addCredentials($manager, $client3, 'user3', 'pass3');

        // Add transactions
        $this -> addTransactions($manager, $client1, $prod1, 100);
        $this -> addTransactions($manager, $client1, $prod2, 50);
        $this -> addTransactions($manager, $client1, $prod3, 25);

        $this -> addTransactions($manager, $client2, $prod1, 111.22);
        $this -> addTransactions($manager, $client2, $prod4, 22.3);
        $this -> addTransactions($manager, $client2, $prod5, 33.44);
        $this -> addTransactions($manager, $client2, $prod6, 44.98);

        $this -> addTransactions($manager, $client3, $prod7, 20.50);
        $this -> addTransactions($manager, $client3, $prod5, 30.25);
    }

    protected function addCredentials(
            ObjectManager &$manager, 
            Clients $client, 
            string $username, 
            string $password, 
            string $status='A'
        ): void{
        try{
            $login = new Login();
            $login
                -> setUsername($username)
                -> setStatus($status)
                -> setPassword(password_hash($password, PASSWORD_DEFAULT))
                -> setClient($client)
            ;
            $manager -> persist($login);
            $manager -> flush();
        }
        catch( Exception $exception){
            throw new \ErrorException("Cannot insert credentials");
        }
    }

    protected function addClient(
            ObjectManager &$manager, 
            string $cui,
            string $name,
            string $address,
            string $city,
            County $county
        ): Clients{
        try{
            $client = new Clients();
            $client
                -> setCui($cui)
                -> setName($name)
                -> setAddress($address)
                -> setCity($city)
                -> setCounty($county)
                -> setInsDate(new \DateTime())
                -> setInsUid('admin')
                -> setModDate(new \DateTime())
                -> setModUid('admin')
                -> setDeleted(false)
            ;
            $manager -> persist($client);
            $manager -> flush();

            return $client;
        }
        catch( Exception $exception){
            throw new \ErrorException("Cannot insert client");
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

    protected function addProduct(
        ObjectManager &$manager, 
        string $name,
        string $description = ''
    ): Products{
        try{
            $product = new Products();
            $product
                -> setName($name)
                -> setDescription($description);
            $manager -> persist($product);
            $manager -> flush();

            return $product;
        }
        catch( Exception $exception){
            throw new \ErrorException("Cannot insert product");
        }
    }

    protected function addTransactions(
        ObjectManager &$manager, 
        Clients $client,
        Products $product,
        string $amount,
        string $date = '',
        bool $status = false
    ): Transactions{
        try{
            $transaction = new Transactions();
            $transaction
                -> setClient($client)
                -> setProduct($product)
                -> setAmount($amount)
                -> setDate($date ?: new \DateTime())
                -> setStatus($status)
                -> setInsDate(new \DateTime())
                -> setInsUid('admin')
                -> setModDate(new \DateTime())
                -> setModUid('admin')
                -> setDeleted(0)
            ;
            $manager -> persist($transaction);
            $manager -> flush();

            return $transaction;
        }
        catch( Exception $exception){
            throw new \ErrorException('Cannot insert transaction');
        }
    }
}
