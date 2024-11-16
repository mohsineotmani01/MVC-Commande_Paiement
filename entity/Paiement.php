<?php



require_once __DIR__ . "/Commande.php";

class Paiement
{
    public $id;
    public $code;
    public $montant;
    public $type;
    public Commande $commande;

    public function __construct($code, $montant, $type, $commande, $id = null)
    {
        $this->id = $id;
        $this->code = $code;
        $this->montant = $montant;
        $this->type = $type;
        $this->commande = $commande;
    }


    public function getCommande()
    {
        return $this->commande;
    }


    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getCode()
    {
        return $this->code;
    }


    public function setCode($code)
    {
        $this->code = $code;
    }


    public function getMontant()
    {
        return $this->montant;
    }


    public function setMontant($montant)
    {
        $this->montant = $montant;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setType($type)
    {
        $this->type = $type;
    }


}