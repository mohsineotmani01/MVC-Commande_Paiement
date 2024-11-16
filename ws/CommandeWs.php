<?php


require_once __DIR__ . "/../service/CommandeService.php";
require_once __DIR__ . "/../entity/Commande.php";

class CommandeWs
{
    private $service;


    public function __construct()
    {
        $this->service = new CommandeService();
    }

    public function save(Commande $commande)
    {
        $response = [];//pas nessaire
        $result = $this->service->save($commande);
        if ($result == -1) {
            $response = ["status" => "500", "data" => "command already exist "];
        } elseif ($result == -2) {
            $response = ["status" => "500", "data" => " total is negatif "];
        } elseif ($result == -3) {
            $response = ["status" => "500", "data" => " totalpaye  est diffèrent de zéro "];
        }else
            $response = ["status" => "201", "data" => "save  ok "];

        return json_encode($response);

    }

    public function payer($ref, $montant)
    {
        $response = [];
        $result = $this->service->payer($ref, $montant);
        if ($result == -1) {
            $response = ["status" => "500", "data" => "command not found "];
        } elseif ($result == -2) {
            $response = ["status" => "500", "data" => " Montant + totalPaye depasse le total "];
        }else
            $response = ["status" => "200", "data" => "payement   ok "];
        return json_encode($response);
    }

    public function deleteByRef($ref)
    {
        $response = [];
        $result = $this->service->deleteByRef($ref);
        if ($result == -1) {
            $response = ["status" => "204", "data" => "no data found"];
        }elseif ($result == -2) {
            $response = ["status" => "500", "data" => " Commande could not be deleted since the payment process have been already started"];
        }else
            $response = ["status" => "200", "data" => "delete ok "];
        return json_encode($response);

    }
    public function deleteById($id)
    {
        $response = [];
        $result = $this->service->deleteById($id);
        if ($result == -1) {
            $response = ["status" => "204", "data" => "no data found "];
        } elseif ($result == -2) {
            $response = ["status" => "500", "data" => " Commande could not be deleted since the payment process have been already started"];
        }else
            $response = ["status" => "200", "data" => "delete ok "];
        return json_encode($response);

    }
    public function update(Commande $commande)
    {

        $this->service->update($commande) ;
        $response = ["status" => "200", "data" => "command updated  "];
        return json_encode($response);
    }


    ///ajouter une conndition verifier l existance id
   /* public function update(Commande $commande)
    {
        // Vérifie si la commande existe dans la base de données
        $existingCommande = $this->service->findById($commande->getId());
        if (!$existingCommande) {
            return json_encode(["status" => 400, "data" => "No modification made. Check if the ID exists."]);
        }
        // Effectue la mise à jour
        $this->service->update($commande);
        return json_encode(["status" => 200, "data" => "command updated  ."]);
    }*/


    public function findById($id)
    {
        $result =  $this->service->findById($id) ;
        if ($result != null){
            $response = [ "status" => "200", "data" => $result ];
        }else
            $response = [ "status" => "204", "data" => "no data found" ];
        return  json_encode($response);
    }
    ///sa plus pratique

    public function findByRef($ref)
    {
        $result = $this->service->findByRef($ref);
        $response = [];
        if ($result != null) {
            $response = ["status" => "200", "data" => $result];
        }else{
            $response = ["status" => "204", "data" => "No data found"];
        }
        return json_encode($response);

    }

    /*
    public function findByRef($ref) {
        $commande = $this->service->findByRef($ref);

        if ($commande) {
            $response = [
                "id" => $commande->getId(),
                "ref" => $commande->getRef(),
                "total" => $commande->getTotal(),
                "totalPaye" => $commande->getTotalPaye()

            ];
            echo json_encode($response);
        } else {
            echo json_encode(["status" => 204, "data" => "No data found for ref: $ref"]);
        }
    }
*/


    public function findAll()
    {

        $result = $this->service->findAll();
        if (!empty($result)){
            $response = [ "status" => "200", "data" => $result ];
        }else
            $response = [ "status" => "204", "data" => "no data found" ];
        return  json_encode($response);
    }
}