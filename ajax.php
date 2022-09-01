<?php
include 'app/Db.php';

$db = new Db();

if(!empty($_POST['search'])){
    $search = $_POST['search'];
    $res = $db->search($search);
    echo $res;

}