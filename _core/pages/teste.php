<?php

$rs = mysqli_query($conn, "select * from grupos where nome like '%%'");

if($rs-> num_rows > 0){
    while ($row = mysqli_fetch_assoc($rs)){
        print_r($row);
    }

}else{
    echo "Nenhum registro encontrado.";
}


?>