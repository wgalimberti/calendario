<?php

$imgField = 'img';
$title = 'Depoimentos';
$table = 'depoimentos';
$fields = [
    ['field'=> 'data', 'size'=> 3, 'name'=>'Data'],
    ['field'=> 'titulo', 'size'=> 3, 'name'=>'Titulo'],
    ['field'=> 'id_categoria', 'size'=> 6, 'name'=>'ID Categoria'],
    ];

$search = "1=1";
$busca = isset($_GET['busca']) ? $_GET['busca']: "";

if($busca!= ""){
    $search = "nome like '%{$busca}%' or email like '%{$busca}%' or login like '%{$busca}%'";
}

function showForm($dados){
    echo '
    <div class="col-sm-20">

        <label>ID Categorias</label>
        <select name="id_categoria" class="form-control">
        '.categorias(isset($dados['id_categoria']) ? $dados['id_categoria']: "").'
        </select>

        <label>Titulo</label>
        <input type="text" name="titulo" class="form-control" value="'.(isset($dados['titulo']) ? $dados['titulo']: "").'" />

        <label>Subtítulo</label>
        <input type="text" name="subtitulo" class="form-control" value="'.(isset($dados['subtitulo']) ? $dados['subtitulo']: "").'" />

        <label>Texto</label>
        <textarea rows="5" name="texto" class="form-control">'.(isset($dados['texto']) ? $dados['texto']: "").'</textarea>

        <label>Imagem</label>
        <input type="file" accept="image/png, image/jpeg" name="img" class="form-control" value="'.(isset($dados['img']) ? $dados['img']: "").'" />
        
        <label>Data</label>
        <input type="date" name="data" class="form-control" value="'.(isset($dados['data']) ? $dados['data']: "").'" />
        
        <label>Autor</label>
        <input type="name" name="autor" class="form-control" value="'.(isset($dados['autor']) ? $dados['autor']: "").'" />
        
    </div>';
}

function categorias($id_categoria){
    $op = "";
    $conn = conecta();
    $rs = mysqli_query($conn, "SELECT * FROM categorias ORDER BY nome");
    while($row = mysqli_fetch_assoc($rs)){
        $sel = '';
        if($id_categoria == $row['id']){
            $sel = 'selected';
        }
        $op .= '<option '.$sel.' value="'.$row['id'].'">'.$row['nome'].'</option>';
    }
    return $op;
}

function saveForm($acao, $id){
    global $table, $config;
    
    //print_r($_FILES); exit;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : "";
    $texto = isset($_POST['texto']) ? $_POST['texto'] : "";
    $img = "";
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $autor = isset($_POST['autor']) ? $_POST['autor'] : "";
    $id_categoria = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : "";
    
    if($_FILES['img']['name'] != 0){
        $nmImg = md5(time()).$_FILES['img']['name'];
        if(!move_uploaded_file($_FILES['img']['tmp_name'], $config['DefaultPath'].'uploads/depoimentos/'.$nmImg)){
            $nmImg = "";
        }else{
            if($id > 0){
                $sql = "SELECT img FROM $table WHERE id=$id AND img <>''";
                $conn = conecta();
                $rs = mysqli_query($conn, $sql);
                if($row = mysqli_fetch_assoc($rs)){
                    unlink($config['DefaultPath'].'uploads/depoimentos/'.$row['img']);
                }
            }
        }
        $img = $nmImg;
        //a variavel recebe o resultado da verificação.
    }
    
    $fields = ['titulo'=> $titulo, 'subtitulo'=> $subtitulo, 'texto'=> $texto,
     'img'=> $img, 'data'=> $data, 'autor'=> $autor, 'id_categoria'=> $id_categoria];

    if($acao == 'add'){
        tableInsert($table, $fields);
        redirect('depoimentos', 'success-add');
    }else{
        tableUpdate($table, $fields, $id);
        redirect('depoimentos', 'success-edit');
    }
}


require __DIR__.'/../inc/crud.php';
