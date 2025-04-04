<?php

namespace App\Repository;

use App\Entity\Login;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Login>
 */
class LoginRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Login::class);
    }

    public function save(Login $login, bool $flush = false) : void{
        $em = $this -> getEntityManager();
        $em -> persist($login);
        if($flush) $em -> flush();
    }

    public function delete(Login $login, bool $flush = false) : void{
        $em = $this -> getEntityManager();
        $em -> remove($login);
        if($flush) $em -> flush();
    }

    public function getRecByUserPass(string $username, string $password) : ?Login{
        $query = $this -> createQueryBuilder('qLogin');
        $query 
            -> where('qLogin.username = :username')
            -> andWhere('qLogin.password = :password')
            -> andWhere("qLogin.status = :status")
            -> setParameters(
                    new ArrayCollection ([
                            new Parameter('username', $username),
                            new Parameter('password', md5($password)),
                            new Parameter('status', 'A')
                        ]
                    )
            );  
        $resp = $query -> getQuery();
        return $resp -> getOneOrNullResult();
    }
}
