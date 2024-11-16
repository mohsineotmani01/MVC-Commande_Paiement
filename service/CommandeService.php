<?php


require_once __DIR__ . "/../dao/CommandeDao.php";
require_once __DIR__ . "/../entity/Commande.php";


class CommandeService{
    private  $dao ;

    public function __construct() {
        $this->dao = new CommandeDao();
    }

    public function save(Commande $commande)
    {
        $loaded= $this->dao->findByRef($commande->getRef());
        if($loaded != null )
            return -1 ;
        elseif($commande->getTotal() <= 0 )
            return -2;
        elseif ($commande->getTotalPaye() != 0 )
            return -3 ;
        else{
            $commande->setEtat("intialised ");
            $this->dao->save($commande) ;
            return 1 ;
        }
    }

    public function payer($ref , $montant )
    {
        $loaded= $this->dao->findByRef($ref);
        if($loaded == null )
            return -1 ;
        $newTotal = $loaded->getTotalPaye() + $montant ;
        if( $newTotal > $loaded->getTotal()   )
            return -2;
        else{
            if($newTotal <= $loaded->getTotal())
                $loaded->setEtat("padding");
            else
                $loaded->setEtat("validated");
            $loaded->setTotalPaye($newTotal);
            $this->dao->update($loaded) ;
            return 1 ;
        }
    }
    public function deleteByRef($ref){
        $loaded= $this->dao->findByRef($ref);
        if($loaded == null )
            return -1 ;
    if(  $loaded->getTotalPaye() != 0 )
            return -2;
        else{
            $this->dao->deleteByRef($ref) ;
            return 1 ;
        }
    }

    public function deleteById($id){
        $loaded = $this->dao->findById($id);
        if($loaded == null )
            return -1 ;
        if( $loaded->getTotalPaye() != 0 )
            return -2;
        else{
            $this->dao->deleteById($id) ;
            return 1 ;
        }
    }


    public function update(Commande $commande)
    {
        return $this->dao->update($commande) ;
    }
    public function findById($id)
    {
        return  $this->dao->findById($id) ;


    }
    public function findByRef($ref)
    {
        return $this->dao->findByRef($ref) ;
    }
    public function findAll()
    {
        return $this->dao->findAll() ;
    }

}