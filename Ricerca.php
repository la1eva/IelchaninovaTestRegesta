<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Regesta";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn){
  echo "Sorry, we experiencing some problems, please try again later";
  die("Connection failed: " . mysqli_connect_error());
}

$product = $_POST["product"];
$model = $_POST["model"];
$amount = $_POST["amount"];
$date = $_POST["date"];
$flag = $_POST["flag"];

function countDays($date){
  $today = date("Y-m-d");
  $days = floor((strtotime($date) - strtotime($today)) / 86400);
  return $days;
}

function totalPrice($case, $price, $request, $discount, $amount){
  $total = $price*$amount;
  $newTotal = $total - ($price * $discount/100);
  switch($case){
    case 1: 
      if($amount >= $request){return $newTotal;}else{return $total;};
    case 2: 
      if($total >= $request){return $newTotal;}else{return $total;};
    case 3:
      $today = getdate();  // i mesi da 1 a 12 secondo la documentazione php 
      if($today["mon"] == $request) {return $newTotal;}else{return $total;};
    }
  };


$sql1 = "SELECT aboutP.supplier, aboutP.price, stock.id AS stockId, stock.amount, suppliers.name, suppliers.delivery, aboutP.id 
        FROM (SELECT supplier, price, id FROM products WHERE model ='$model' AND name = '$product'  ) AS aboutP, stock,  suppliers
        WHERE aboutP.supplier = suppliers.id 
        AND aboutP.id = stock.product";

$result = mysqli_query($conn, $sql1);



$S = "";
$i = 1;
$bestChoice = "nothing";
$bestPrice = 9999999999999;
$delivery = 9999999999999;

if (mysqli_num_rows($result) > 0){
    foreach ($result as $r){
        $stockId = $r["stockId"];
            $sqlRestock = "SELECT restock.next, restock.amount AS restockAmount, stock.amount AS stockAmount
            FROM stock, restock
            WHERE stock.id = '$stockId'
            AND stock.id = restock.stock ";
          
        $result1 = mysqli_query($conn, $sqlRestock);

        $days = countDays($date);
        foreach ($result1 as $s){
            $next = $s["next"];
            $restockAmount = $s["restockAmount"];
            $stockAmount = $s["stockAmount"];
        }
        // nell'immediato
        if($days == 0 && $r["amount"] < $amount || ( $r["amount"] < $amount && (floor((strtotime($date) - strtotime($s["next"])) / 86400) < 0) || (($s["restockAmount"] + $s["stockAmount"]) < $amount ))){ 

          $output = $i.") Supplier ".$r["name"]." is not prompted because it does not have enough stock quantity available"."\n";
          unset($r);
          $i++;
        
        }else{

            

          if(($r["amount"] > $amount) ||((floor((strtotime($date) - strtotime($s["next"])) / 86400) > 0) || (($s["restockAmount"] + $s["stockAmount"]) > $amount ))){
          $id = $r["id"]; 
          $totalPrice = $r["price"]*$amount;

          $sql2 = "SELECT code, discount, request
          FROM discounts
          WHERE product =  '$id'";
          $result2 = mysqli_query($conn, $sql2);
            
            

          if (mysqli_num_rows($result2) > 0){
            foreach ($result2 as $t){
              $totalPrice = totalPrice($t["code"], $r["price"], $t["request"], $t["discount"], $amount);
              $output = $i.") Supplier ".$r["name"]." can fulfill the request for ".$totalPrice."$";
              $i++;
            }
          }else{
            $output = $i.") Supplier ".$r["name"]." can fulfill the request for ".$totalPrice."$";
            $i++;
          }

            
          if(!$flag){
            if($bestPrice > $totalPrice || ($bestPrice == $totalPrice && $delivery > $r["delivery"])){
              $bestChoice = $output;
              $bestPrice = $totalPrice;
              $delivery = $r["delivery"];
            }
            }else{
              if($delivery > $r["delivery"]){
                $bestChoice = $output;
                $delivery = $r["delivery"];
              }
            }

          if($days == 0 || $days >= $r["delivery"]){
            if($bestChoice === $output) {$bestChoice .= " in ".$r["delivery"]." days \n";}
            $output .= " in ".$r["delivery"]." days \n";
          }
          
        }
          
      } 
      $S .= $output."\n";
    }
  }else{
  echo "fail";
  }
  sleep(1);
  echo str_replace ( $bestChoice,"------------|Best choise|\n".$bestChoice."------------\n",  $S);
  mysqli_close($conn);

?>
