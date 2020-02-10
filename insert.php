<?php
// require_once "db.php";
// header('Access-Control-Allow-Origin:*');
//echo '123';
$option='';
$name ='';
$context='';

$option = $_POST['option'] ? $_POST['option'] : '';


switch($option){

    case 'insert':
        $name = $_POST['name'];
        $context = $_POST['context'];
        echo json_encode(insert($name, $context));
        break;
    case 'delete':
        $id = $_POST['id'];
        echo json_encode(delete($id));
        break;
    case 'edit':
        $updateId = $_POST['updateId'];
        $updateName = $_POST['updateName'];
        $updateContext = $_POST['updateContext'];
        echo json_encode(edit($updateId, $updateName, $updateContext));
        break;
    case 'view':
        echo json_encode(view());
        break;

}
function view(){
    require_once "db.php";
    $sql = "SELECT `id`,`name`,`context` FROM `context`ORDER BY `context`.`id` ASC";
    $res = $conn->query($sql)or die($conn->connect_error);
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $conn->close();
    return json_encode($data);
}
function insert($name,$context) {
    require_once "db.php";
    $sql = "INSERT INTO `context` (`id`, `name`, `context`, `other`) VALUES (NULL,'$name','$context','')";
    $res = $conn->query($sql);
    $conn->close();
    $data = ['新增成功'];
    return $data;
}
function delete($id) {
    require_once "db.php";
    $sql = " DELETE FROM `context` WHERE `context`.`id` = '$id'";
    $res = $conn->query($sql);
    $conn->close();
    $data = ['刪除成功'];
    return $data;
}
function edit($updateId, $updateName, $updateContext) {
    require_once "db.php";
    $sql = " UPDATE `context` SET `name` = '$updateName', `context` = '$updateContext' WHERE `context`.`id` = '$updateId';";
    $res = $conn->query($sql);
    $conn->close();
    $data = ['修改成功'];
    return $data;
}

?>