<?php
include_once 'php/db_connect.php';

$aMotsA=[
["animal","mots/A"],
["bille","mots/A"],
["bol","mots/A"],
["camarade","mots/A"],
["caramel","mots/A"],
["carton","mots/A"],
["chaleur","mots/A"],
["chose","mots/A"],
["farine","mots/A"],
["feu","mots/A"],
["fille","mots/A"],
["fleur","mots/A"],
["fromage","mots/A"],
["marche","mots/A"],
["neveu","mots/A"],
["noir","mots/A"],
["parent","mots/A"],
["partir","mots/A"],
["potiron","mots/A"],
["poulet","mots/A"],
["premier","mots/A"],
["sardine","mots/A"],
["seul","mots/A"],
["sucre","mots/A"],
["tartine","mots/A"],
["tasse","mots/A"],
["tigre","mots/A"],
["trou","mots/A"],
["vendredi","mots/A"],
["ventre","mots/A"],
["vitrine","mots/A"]
];

$aMotsB=[ 
 ["acier","mots/B"],
["besoin","mots/B"],
["blouse","mots/B"],
["bois","mots/B"],
["campeur","mots/B"],
["chaise","mots/B"],
["chance","mots/B"],
["chanson","mots/B"],
["chienne","mots/B"],
["cousin","mots/B"],
["deux","mots/B"],
["dindon","mots/B"],
["espoir","mots/B"],
["fleuve","mots/B"],
["froid","mots/B"],
["gant","mots/B"],
["jambon","mots/B"],
["lange","mots/B"],
["ligne","mots/B"],
["long","mots/B"],
["montagne","mots/B"],
["orange","mots/B"],
["pantalon","mots/B"],
["poison","mots/B"],
["poisson","mots/B"],
["quille","mots/B"],
["raisin","mots/B"],
["renard","mots/B"],
["six","mots/B"],
["soigner","mots/B"],
["valise","mots/B"],
["volaille","mots/B"],
["voyage","mots/B"]   
];

$aMotsC=[
["adresse","mots/C"],
["allonger","mots/C"],
["aviation","mots/C"],
["bijou","mots/C"],
["bouillon","mots/C"],
["caillou","mots/C"],
["carotte","mots/C"],
["champion","mots/C"],
["choix","mots/C"],
["commode","mots/C"],
["courrier","mots/C"],
["cravate","mots/C"],
["crayon","mots/C"],
["culotte","mots/C"],
["femme","mots/C"],
["feuille","mots/C"],
["fils","mots/C"],
["flamme","mots/C"],
["heureux","mots/C"],
["homme","mots/C"],
["horloger","mots/C"],
["jaloux","mots/C"],
["jamais","mots/C"],
["loup","mots/C"],
["monsieur","mots/C"],
["mouiller","mots/C"],
["oreiller","mots/C"],
["pavillon","mots/C"],
["pigeon","mots/C"],
["pompon","mots/C"],
["souhait","mots/C"],
["soupir","mots/C"],
["sourire","mots/C"],
["taquiner","mots/C"],
["terrain","mots/C"],
["toujours","mots/C"],
["tronc","mots/C"]
];

$aMotsD=[
["accident","mots/D"],
["addition","mots/D"],
["agrafe","mots/D"],
["arracher","mots/D"],
["atterrir","mots/D"],
["autocar","mots/D"],
["buffet","mots/D"],
["ceinture","mots/D"],
["chahuter","mots/D"],
["clown","mots/D"],
["commis","mots/D"],
["comptoir","mots/D"],
["courir","mots/D"],
["cyclisme","mots/D"],
["dizaine","mots/D"],
["doigt","mots/D"],
["drap","mots/D"],
["dynamo","mots/D"],
["examen","mots/D"],
["exciter","mots/D"],
["exclu","mots/D"],
["hache","mots/D"],
["hachis","mots/D"],
["hareng","mots/D"],
["houille","mots/D"],
["inclus","mots/D"],
["larynx","mots/D"],
["mourir","mots/D"],
["passion","mots/D"],
["photo","mots/D"],
["phrase","mots/D"],
["physique","mots/D"],
["plomb","mots/D"],
["skieur","mots/D"],
["souffrir","mots/D"],
["soufre","mots/D"],
["thorax","mots/D"],
["tricycle","mots/D"]
];
  
//connect to db


$arr=$aMotsD;
for($i = 0; $i < count($arr); ++$i) {

$words=$arr[$i][0];
$folder=$arr[$i][1];
$level=substr($arr[$i][1], -1);
 $sql = "INSERT INTO `words`
(words, folder, level)
VALUES ('$words', '$folder', '$level')";
//  echo $words .', '.$folder;
//  var_dump( $words );
if ($conn->query($sql) === TRUE) {
//    echo "Record updated successfully";
    //return Id
 
 
    
} else {
    echo "Error update creating entry: " . $conn->error;
}


}

  mysqli_close($conn);  