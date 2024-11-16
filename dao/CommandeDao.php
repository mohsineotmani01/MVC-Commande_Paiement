<?php


require_once __DIR__ . "/../entity/Commande.php";
class CommandeDao
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=tp1_est", "root", "");
    }

    public function save(Commande $commande)
    {
        $statement = $this->pdo->prepare("INSERT INTO commande(ref ,total , total_paye , etat) values(?, ?, ? ,?)");
        $statement->execute([$commande->getRef(), $commande->getTotal() , $commande->gettotalPaye() ,$commande->getEtat()]);// order tres important
        return 1;
    }


    public function update(Commande $commande)
    {
        $statement = $this->pdo->prepare("UPDATE commande  SET ref=? , total=? , total_paye = ?, etat = ? WHERE id=?");
        $statement->execute([$commande->getRef(), $commande->getTotal(), $commande->gettotalPaye(), $commande->getEtat() ,  $commande->getId()]);
        return 1;
    }

    public function deleteByRef($ref)
    {
        $statement = $this->pdo->prepare("DELETE FROM  commande  WHERE ref=?");
        $statement->execute([$ref]);
        return 1;
    }
    public function deleteById($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM  commande  WHERE id=?");
        $statement->execute([$id]);
        return 1;
    }
    public function findById($id)
    {
        $result = null ;
        $statement = $this->pdo->prepare("SELECT *  FROM commande WHERE id = ?");
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row){
            $result =  new Commande($row['ref'], $row['total'] , $row['total_paye'] ,$row['etat']  ,$row['id'] ) ;
        }
        return $result ;

    }
   public function findByRef($ref)
    {
        $result = null ;
        $statement = $this->pdo->prepare("SELECT *  FROM commande WHERE ref = ?");
        $statement->execute([$ref]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row){
            $result =  new Commande($row['ref'],$row['total'] ,$row['total_paye']  ,$row['etat']  ,$row['id']  ) ;
        }

        return $result ;
    }
    public function findAll()
    {
        $result = [];
        $statement = $this->pdo->prepare("SELECT *  FROM commande" );
        $statement->execute();//Après cette étape, $statement contient les résultats de la requête
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Commande ($row["ref"] ,$row["total"],$row["total_paye"] ,$row['etat']  , $row["id"] );
        }
        return $result ;
    }
    //autre methode
    /*
     public function findAll()
{
    $statement = $this->pdo->prepare("SELECT * FROM commande");
    /// ajouter en cas d erreur
    if (!$statement) {
        throw new Exception("Erreur lors de la préparation de la requête.");
    }

    $statement->execute();
    $result = [];

    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $res) { ///grandes quantités de données, cela peut consommer plus de mémoire
        $result[] = new Commande($res["id"], $res["ref"], $res["total"] ,$row["total_paye"] ,$row['etat']  ,);
    }

    return $result;
}

     */


}