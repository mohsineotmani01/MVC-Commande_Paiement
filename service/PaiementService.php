<?php


require_once __DIR__ .  "/../dao/PaiementDao.php";
require_once __DIR__ .  "/CommandeService.php";

class PaiementService {
    private $dao ;
    private  $commandeService ;

    public function __construct() {

        $this->dao = new PaiementDao();
        $this->commandeService = new CommandeService();

    }


    public function save(Paiement $paiment){
        $commande = $this->commandeService->findByRef($paiment->getCommande()->getRef());
        $paiment->setCommande($commande);
        if($commande === null){
            return - 1 ;
        }elseif ($this->dao->findByCode($paiment->getCode())  !==  null  ){
            return -2 ;
        }elseif( ($commande->getTotalPaye() + $paiment->montant) >= $commande->getTotal()){
            return  -3 ;
        }else {
            $newTotalePaye = $paiment->commande->getTotalPaye() + $paiment->montant ;
            if($newTotalePaye <= $commande->getTotal())
                $commande->setEtat("padding");
            else
                $commande->setEtat("validated");
            $commande->setTotalPaye($newTotalePaye);
            $this->commandeService->update($paiment->commande);
            $this->dao->save($paiment);
            return 1 ;
        }

    }

    public  function  deleteByCommandeRef($ref)
    {
        $loadedCommande = $this->commandeService->findByRef($ref);
        if($loadedCommande === null){
            return -1 ;
         }else{
            $this->dao->deleteByCommandeRef($loadedCommande->getRef());
            $this->commandeService->deleteByRef($ref);
            return 1;
        }
    }

/*
    public  function payer($ref , $montant , $code) {
        $commande = $this->commandeService->findByRef($ref);
        if($commande == null){
            return -1;
        }
        $newTotal = $commande->getTotalPaye() + $montant ;
        if ($newTotal > $commande->getTotal()){
            return  -2 ;
        }else{
            //pour verifier si le paiement exit deja
            if ($this->dao->findByCode($code)  !==  null  ){
                return -3 ;
            }
            $commande->setTotalPaye($newTotal);
            $this->commandeService->update($commande);
            $paiment = new Paiement($code ,$montant,"",$commande  );
            $this->dao->save($paiment);
            return  1 ;

        }
    }

*/
    public  function  finByCommandeRef($ref)
    {
        return $this->dao->finByCommandeRef($ref);
    }


    public  function findByCode($code){
        return $this->dao->findByCode($code);
    }
    public function  findById($id){
        return $this->dao->findById($id);

    }
    public function  findAll(){
        return $this->dao->findAll();
    }

    public function  deleteById($id){
        $loaded= $this->dao->findById($id);
        if($loaded == null )
            return -1 ;
        else{
            return $this->dao->deleteById($id);
        }

    }
    public function  update(Paiement $paiement)
    {
        return $this->dao->update($paiement) ;
    }


}