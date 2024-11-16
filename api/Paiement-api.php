<?php

require_once __DIR__ .  "/../ws/PaiementWs.php";
require_once __DIR__ .  "/../ws/CommandeWs.php";

header('Content-type: Application/json');

$ws = new PaiementWs();
$response = [];
$method = $_SERVER["REQUEST_METHOD"];
$commandeService = new CommandeService();//pas paratique

$url = explode("/"  ,$_SERVER["REQUEST_URI"] ) ;


if($method == "GET"){
    if (isset($url[6] , $url[6])){
        if(($url[5] === "code") ) {
            $response = $ws->findByCode($url[6]);
        }else if( ($url[5] === "id") ){
            $response = $ws->findById($url[6]);
        }else if( ($url[5] === "ref") ){
            $response = $ws->finByCommandeRef($url[6]);
        }
    }else
        $response = $ws->findAll();

}


if ($method == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $commande = $commandeService->findByRef($data["commande"]["ref"]);
        $paiement = new Paiement($data["code"], $data["montant"], $data["type"], $commande);
        $response = $ws->save($paiement);
}




if ($method == "PUT") {
    $input = json_decode(file_get_contents('php://input'), true);
        // Créez une instance de Commande à partir des données reçues
        $commande = new Commande($input["commande"]["ref"],$input["commande"]["total"],$input["commande"]["totalPaye"],$input["commande"]["etat"],$input["commande"]["id"]) ;
        $paiement = new Paiement($input["code"], $input["montant"], $input["type"],$commande , $input["id"]);
        $response = $ws->update($paiement);

}

/*
if ($method == "PUT") {
    $input = json_decode(file_get_contents('php://input'), true);
    if ($_GET["action"] == "update") {
        // Créez une instance de Commande à partir des données reçues
        $commande = new Commande($input["commande"]["ref"],$input["commande"]["total"],$input["commande"]["totalPaye"],$input["commande"]["etat"],$input["commande"]["id"]) ;

        $paiement = new Paiement($input["code"], $input["montant"], $input["type"],$commande , $input["id"]);
        $response = $ws->update($paiement);



    } elseif ($_GET["action"] == "payer") {
        $response = $ws->payer($input["ref"], $input["montant"], $input["code"]); // Paiement d'une commande
    }
}
*/



if ($method == "DELETE") {
    if (isset($_GET["id"])) {
        $response = $ws->deleteById($_GET["id"]); // Suppression par ID
    } elseif (isset($_GET["ref"])) {
        $response = $ws->deleteByCommandeRef($_GET["ref"]); // Suppression par référence
    }
}

echo $response;













/*
if ($method == "GET") {
    if (isset($_GET["code"])) {
        $response = $ws->findByCode($_GET["code"]);
    } elseif (isset($_GET["id"])) { // Recherche par ID
        $response = $ws->findById($_GET["id"]);
    } else {
        $response = $ws->findByAll();
    }
}
*/


/*
 if ($method == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $commandeId = $data["commande_id"]; // Supposons que vous envoyez l'ID de la commande
    $paiement = new Paiement($data["code"], $data["montant"], $data["type"], $commandeId);
    $response = $ws->save($paiement);
}
 */
