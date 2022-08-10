<?php 

// Get Total Count
function getTotalCount($table){
    global $pdo;
    $stm=$pdo->prepare("SELECT id FROM $table");
    $stm->execute();
    $count=$stm->rowCount();
    return $count;
}
  