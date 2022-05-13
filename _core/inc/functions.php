<?php

include_once __DIR__ . "/config.php";

function loadDates(){
    global $config;
    $arq = fopen($config["Filepath"] , "r+");
    $dates = [];
    while($row = fgetcsv($arq, 50, ";")){
        if ($row[0] != "" && $row[1] != ""){
            $dates[] = [
                'data' => $row[0],
                'name' => $row[1],
            ];
        }
    }
    fclose($arq);
    return $dates;
}

function saveDates($arr){
    global $config;
    $arq = fopen($config["Filepath"] , "a+");
    fputcsv($arq, $arr, ";");
    fclose($arq);

}

function hasBday($dia, $mes, $datas){
    $dia = str_pad($dia,2,"0", STR_PAD_LEFT);
    $mes = str_pad($mes,2,"0", STR_PAD_LEFT);
    for ($i = 0; $i < count($datas); $i++){
        if ($datas[$i]['data'] == $dia . $mes){
            return $datas[$i]['name'];
        }
    }
    return "";
}


function loadUser(){
    global $config;
    $arq = fopen($config["User"], "r+");
    $logins = [];    
    while($row = fgetcsv($arq, 1024, ";")){
        if ($row[0] != "" && $row[1] != ""){
            $logins += [
                $row[0] => [
                    'senha' => $row[1],
                    'nome' => $row[2],
                    'email' => $row[3],
                ],
            ];
        }
    }
    fclose($arq);
    return $logins;
}

function saveLogins($arr){
    global $config;
    //apagar o arquivo atual
    unlink($config['User']);

    $arq = fopen($config['User'], 'a+');
    foreach($arr as $key=>$v){
        fputs($arq, "{$key};{$v['senha']};{$v['nome']};{$v['email']}".PHP_EOL);
    }
    fclose($arq);
}
    

function redirect($p, $msg='success'){
    echo "<script> location = './?p={$p}&msg={$msg}'; </script>";
    exit;
}

// --- // -- //

function loadGrup(){
    global $config;
    $arq = fopen($config["Grup"], "r+");
    $grupos = [];    
    while($row = fgetcsv($arq, 1024, ";")){
        if ($row[0] != "" && $row[1] != ""){
            $grupos += [
                $row[0] => $row[1]
            ];
        }
    }
    fclose($arq);
    return $grupos;
}

function saveGrup($arr){
    global $config;
    //apagar o arquivo atual
    unlink($config['Grup']);
   
    $arq = fopen($config['Grup'], 'a+');
    foreach($arr as $key=>$v){
        fputs($arq, "{$key};{$v}".PHP_EOL);
        
        
    }
    fclose($arq);
}


function loadCats(){
    global $config;
    $grupos = [];  
    if(!file_exists($config["Cats"]))
        return $grupos;

    $arq = fopen($config["Cats"], "r");
    while($row = fgetcsv($arq, 1024, ";")){
        if ($row[0] != "" && $row[1] != ""){
            $grupos += [
                $row[0] => $row[1]
            ];
        }
    }
    fclose($arq);
    return $grupos;
}

function saveCats($arr){
    global $config;
    //apagar o arquivo atual
    unlink($config['Cats']);

    $arq = fopen($config['Cats'], 'a+');
    foreach($arr as $key=>$v){
        fputs($arq, "{$key};{$v}".PHP_EOL);
        
        
    }
    fclose($arq);
}

//-----//-----//-----//-----//

function conecta(){
    return mysqli_connect(
        'localhost',
        'root',
        '',
        'estudos',
        3306);
}
       
function tableList($table, $fields, $search = '1=1'){
    $conn = conecta();
    $sql = "select * from {$table} where {$search}";
    $rs = mysqli_query($conn, $sql);
    if($rs->num_rows ==0){
        echo "Nenhum registro encontrado";
        return false;
    }
    echo '<table class="table table-stripped">';
    echo '<thead>';
    echo '<tr>
        <th>&nbsp;</th>';
    foreach ($fields as $field){
        echo "<th class='col-sm-{$field['size']}'>{$field['name']}</th>";
    }
    echo '<th>&nbsp;</th>
    </tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while ($row = mysqli_fetch_assoc($rs)){
        echo '
        <tr>
            <td>
                <a class="btn btn-primary" href="./?p='.$_GET['p'].'&acao=edit&id='.$row['id'].'">Editar</a>
            </td>';
        
        foreach ($fields as $field){
            echo '<td>' .$row[$field['field']].'</td>';
        }
        echo '
        <td>
            <a class="btn btn-danger" href="javascript:;" onclick="javascript:if(confirm(`Deseja excluir o registro?`)){location=`./?p='.$_GET['p'].'&acao=del&id='.$row['id'].'`;}">Excluir</a>
        </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}

function tableDel($table, $id, $imgField = ""){
    $conn = conecta();
    $sql = "delete from {$table} where id={$id}";
    mysqli_query($conn, $sql);
    if($imgField!=""){
        deleteImg($table, $id, $imgField);
    }
}

function deleteImg($table, $id, $field){
    global $config;
    $sql = "SELECT $field FROM $table WHERE id=$id AND $field <>''";
    $conn = conecta();
    $rs = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($rs)){
        unlink($config['DefaultPath'].'uploads/'.$table.'/'.$row[$field]);}
}

function tableInsert($table, $fields){
    $conn = conecta();
    $sql = "INSERT INTO {$table}
    (".implode(',',array_keys($fields)).")
    VALUES
    ('".implode("','",$fields)."')";
    mysqli_query($conn, $sql);
}

function tableUpdate($table, $fields, $id){
    $conn = conecta();
    $miolo = "";
    foreach ($fields as $key => $value) {
        $miolo .= "{$key}='{$value}',";
    }
    $miolo = substr($miolo, 0, -1);
    $sql = "UPDATE {$table} SET $miolo WHERE id={$id}";
    mysqli_query($conn, $sql);
}