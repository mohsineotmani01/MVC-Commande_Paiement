<?php

require_once __DIR__ .  "/../entity/Paiement.php";
require_once __DIR__ .  "/../dao/commandeDao.php";
class PaiementDao
{
        private  $pdo ;
        private  $commandeDao ;

        public  function  __construct()
        {
            $this->pdo = new PDO("mysql:host=localhost;dbname=tp1_est", "root", "");
            $this>$this->commandeDao = new commandeDao();
        }
        public function save(Paiement $paiement)
        {
            $statement = $this->pdo->prepare("INSERT INTO paiement (code ,montant , type ,commande_id) values(?, ?, ? ,?)");
            $statement->execute([$paiement->getCode(), $paiement->getMontant(), $paiement->getType(), $paiement->getCommande()->getId()]);
            return 1;
        }

    public function update(Paiement $paiement)
    {
        $statement = $this->pdo->prepare("UPDATE paiement SET code = ?, montant = ?, type = ?, commande_id = ? WHERE id = ?");
        $statement->execute([$paiement->getCode(), $paiement->getMontant(), $paiement->getType(), $paiement->getCommande()->getId(), $paiement->getId()]);
        return 1;
    }

    //delete
    public  function  deleteByCode($code)
        {
             $statement = $this->pdo->prepare("DELETE FROM paiement WHERE code = ?");
             $statement->execute([$code]);
             return 1 ;
        }

        public  function  deleteById($id)
        {
             $statement = $this->pdo->prepare("DELETE FROM paiement WHERE id = ?");
             $statement->execute([$id]);
             return 1 ;
        }

        ///find
    public function findById($id)
    {
        $result = null ;
        $statement = $this->pdo->prepare("SELECT *  FROM paiement WHERE id = ?");
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row){
            $commande = $this->commandeDao->findById($row['commande_id']);
            $result =  new Paiement($row['code'], $row['montant'] , $row['type'] ,$commande, $row['id'] ) ;
        }
        return $result ;

    }
    public function findByCode($code)
    {
        $result = null ;
        $statement = $this->pdo->prepare("SELECT *  FROM paiement WHERE code = ?");
        $statement->execute([$code]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row){
            $commande = $this->commandeDao->findById($row['commande_id']);
            $result =  new Paiement($row['code'], $row['montant'] , $row['type'] , $commande, $row['id'] ) ;
           
        }

        return $result ;
    }
    public  function    findAll()
    {
        $statement = $this->pdo->prepare("SELECT *  FROM paiemeQnt");
        $statement->execute();
        $result = [];
        while ($row= $statement->fetch(PDO::FETCH_ASSOC)){
            $commande = $this->commandeDao->findById($row['commande_id']);
            $result[] = new Paiement($row['code'], $row['montant'] , $row['type'] ,$commande, $row['id'] );
        }
        return $result ;

    }

    ///pour commande

    public  function  deleteByCommandeRef($ref)
    {
        //$statement = $this->pdo->prepare("DELETE FROM paiement WHERE commande_id = (SELECT id FROM commande WHERE ref = ?)");
        $loadedcommande = $this->commandeDao->findByRef($ref);
        if($loadedcommande !== null ){
            $statement = $this->pdo->prepare("DELETE FROM paiement WHERE commande_id = ?");
            $statement->execute([$loadedcommande->getId()]);
            return 1 ;
        }
        return  0 ;

    }

    public  function  finByCommandeRef($ref)
    {
        $statement = $this->pdo->prepare("SELECT p.*  FROM paiement p , commande c WHERE  p.commande_id = c.id AND c.ref = ?");
        $statement->execute([$ref]);
        $result = [];
        while ($row= $statement->fetch(PDO::FETCH_ASSOC)){
            $commande = $this->commandeDao->findById($row['commande_id']);
            $result[] = new Paiement($row['code'], $row['montant'] , $row['type'] ,$commande, $row['id'] );
        }
        return $result ;


    }




}