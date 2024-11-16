<?php


require_once __DIR__ .  "/../service/PaiementService.php";
require_once __DIR__ .  "/../entity/Paiement.php";

class PaiementWs {
    private $service;

    public function __construct() {
        $this->service = new PaiementService();
    }

    public function save(Paiement $paiement) {
        $result = $this->service->save($paiement);
        $response = [];

        if ($result == -1) {
            $response = ["status" => "204", "data" => "data not found"];
        } elseif ($result == -2) {
            $response = ["status" => "500", "data" => " le paiement existe deja"];
        } elseif ($result == -3) {
            $response = ["status" => "500", "data" => "ouveau total paye (totalPaye + montant) est supérieure au total"];
        } else {
            $response = ["status" => "201", "data" => "Paiement enregistre avec succes"];
        }

        return json_encode($response);
    }


    /*
    public function payer($ref, $montant, $code) {
        $result = $this->service->payer($ref, $montant, $code);
        $response = [];

        if ($result == -1) {
            $response = ["status" => "500", "data" => "Commande introuvable"];
        } elseif ($result == -2) {
            $response = ["status" => "500", "data" => "Montant paye depasse le total de la commande"];
        }  elseif ($result == -3) {
            $response = ["status" => "500", "data" => "Paiement exist deja "];
        } else {
            $response = ["status" => "200", "data" => "Paiement effectue avec succes"];
        }

        return json_encode($response);
    }

*/
    public function deleteByCommandeRef($ref) {
        $result = $this->service->deleteByCommandeRef($ref);
        $response = [];

        if ($result == -1) {
            $response = ["status" => "204", "data" => "Aucune commande trouvee"];
        } else{
            $response = ["status" => "200", "data" => "Commande et paiements associes supprimés avec succes"];
        }
        return json_encode($response);
    }

    public  function  finByCommandeRef($ref) {
            $result = $this->service->finByCommandeRef($ref);
            $response = [];
        if ($result != null){
            $response = [ "status" => "200", "data" => $result ];
        }else
            $response = [ "status" => "204", "data" => "no data found" ];
        return  json_encode($response);
    }
    public function deleteById($id) {
        $result = $this->service->deleteById($id);
        if ($result == -1) {
            $response = ["status" => "204", "data" => "no data found"];
        } else
            $response = ["status" => "200", "data" => "Paiement supprimé avec succes "];
        return json_encode($response);

    }

    public function findByCode($code) {
        $result = $this->service->findByCode($code);
        if ($result != null){
            $response = [ "status" => "200", "data" => $result ];
        }else
            $response = [ "status" => "204", "data" => "no data found" ];
        return  json_encode($response);
    }

    public function findById($id) {
        $result = $this->service->findById($id);
        if ($result != null){
            $response = [ "status" => "200", "data" => $result ];
        }else
            $response = [ "status" => "204", "data" => "no data found" ];
        return  json_encode($response);
    }

    public function findAll() {
        $result = $this->service->findAll();
        if (!empty($result)){
            $response = [ "status" => "200", "data" => $result ];
        }else
            $response = [ "status" => "204", "data" => "no data found" ];
        return  json_encode($response);
    }



    public function update(Paiement $paiement) {
        $result = $this->service->update($paiement);
        return json_encode(["status" => "200", "data" => "Paiement mis e jour avec succes"]);
    }
}
