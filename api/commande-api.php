<?php


require_once __DIR__ .  "/../ws/CommandeWs.php";

header('Content-type: Application/json');

$ws = new CommandeWs();
$response = [];
$method = $_SERVER["REQUEST_METHOD"];
$url = explode("/"  ,$_SERVER["REQUEST_URI"] ) ;
//print_r($url);
//  /myphp/tpPhpTest/tp1-v1/Commande-api.php/ref/c1

    if($method == "GET"){
        if (isset($url[6] , $url[6])){  //if(isset($_GET["ref"])
            if(($url[5] === "ref") ) { //si une variable est définie et si sa valeur n'est pas null.
                $response = $ws->findByRef($url[6]);
            }else if( ($url[5] === "id") ){
                $response = $ws->findById($url[6]);
            }
        }else
            $response = $ws->findAll();

    }

    if ($method == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
            $commande = new Commande($data["ref"], $data["total"], $data["totalPaye"] , $data["etat"]);
            $response = $ws->save($commande);
        }

    if ($method == "PUT") {
        $input = json_decode(file_get_contents('php://input'), true);
        if ($_GET["action"] == "update") {
            $commande = new Commande($input["ref"],$input["total"],$input["totalPaye"] , $input["etat"], $input["id"]);/// pour requiperer id dans url  $_GET["id"]
            $response = $ws->update($commande);
        } elseif ($_GET["action"] == "payer" ) {
            $response = $ws->payer($input["ref"],$input["montant"]);
        }
    }
    if ($method == "DELETE") {
    if(isset($_GET["id"]))
            $response = $ws->deleteById($_GET["id"]);
    elseif  (isset($_GET["ref"]))
        $response = $ws->deleteByRef($_GET["ref"]);

    }

    echo $response;







    //ajouter de condition pour put et post
        /*
    if ($method == "PUT") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data["action"]) && $data["action"] === "updatePayment") {
        if (isset($data["ref"]) && isset($data["montant"])) {
            $ref = $data["ref"];
            $montant = $data["montant"];
            $response = $ws->payer($ref, $montant);
        } else {
            $response = json_encode(["status" => 400, "data" => "Invalid input data for payment"]);
        }
    } elseif (isset($data["id"]) && isset($data["ref"]) && isset($data["total"]) && isset($data["totalPaye"] ,isset($data["etat"])) {
        $commande = new Commande($data["ref"], $data["total"], $data["totalPaye"], $data["etat"] ,$data["id"]  );
        $response = $ws->update($commande);
    } else {
        $response = json_encode(["status" => 400, "data" => "Invalid input data"]);
    }
    }*/