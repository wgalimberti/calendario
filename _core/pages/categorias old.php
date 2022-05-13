<?php

$Title = 'Categorias';
function loadItens(){
    return loadCats();
}
function saveItens($arr){
    saveCats($arr);
}

require __DIR__.'/../inc/crud.php';