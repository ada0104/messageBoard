<?php

require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if (!isset($method)){
    return ['未帶入參數'];
};

  switch ($_SERVER['REQUEST_METHOD'])
  {
    case 'POST':
        $option = $_POST['option'] ? $_POST['option'] : '';
      break;
    case 'GET':
        $option = $_GET['option'] ? $_GET['option'] : '';
      break;
    case 'DELETE':
        $option = 'delete';
      break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $_PUT);
        $option = $_PUT['option'];
      break;
  };


if($option === 'insert'){
    $name = $_POST['name'];
    $context = $_POST['context'];
    $name = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $name));
    $context = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $context));
    echo json_encode(insert($name, $context));
}elseif($option === 'delete'){
    $id = $_SERVER['QUERY_STRING'];
    $id = htmlspecialchars(preg_replace('/[^\d]/', '',$id));
    echo json_encode(delete($id));
}elseif($option === 'edit'){
    $updateId = $_PUT['updateId'];;
    $updateName = $_PUT['updateName'];;
    $updateContext = $_PUT['updateContext'];;
    $updateId = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $updateId));
    $updateName =  htmlspecialchars(preg_replace("/[\'\"]+/" , '', $updateName));
    $updateContext =  htmlspecialchars(preg_replace("/[\'\"]+/" , '', $updateContext));
    echo json_encode(edit($updateId, $updateName, $updateContext));
}elseif($option === 'view'){
    echo json_encode(view());
};

function view(){
    global $conn;
    $sql = 'SELECT id,name,context FROM context ORDER BY context.id ASC';
    $res = $conn->query($sql)or die($conn->connect_error);
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $conn->close();
    return json_encode($data);
}
function insert($name,$context) {
    global $conn;
    $sql = "INSERT INTO context (id, name, context, other) VALUES (NULL,'$name','$context','')";
    $res = $conn->query($sql);
    $conn->close();
    return ['新增成功'];
}
function delete($id) {
    global $conn;
    $sql ="SELECT EXISTS(SELECT * FROM context WHERE id = '$id')";
    $res = $conn->query($sql);
    if($res){
        $sql = "DELETE FROM context WHERE context.id = '$id'";
        $res = $conn->query($sql);
        $conn->close();
        return ['刪除成功'];
    }else{
        return ['無此筆資料'];
    }
}
function edit($updateId, $updateName, $updateContext) {
    global $conn;
    $sql ="SELECT EXISTS(SELECT * FROM context WHERE id = '$updateId')";
    $res = $conn->query($sql);
    if($res){
        $sql = "UPDATE context SET name = '$updateName', context = '$updateContext' WHERE context.id = '$updateId'";
        $res = $conn->query($sql);
        $conn->close();
        return  ['修改成功'];
    }else{
        return ['無此筆資料'];
    }

}
// $returnData = $dbh->prepare("SELECT
// user_info.user_id,
// user_info.uname,
// organization.name,
// user_info.grade,
// user_info.class
// FROM
// user_family
// LEFT JOIN
// user_info ON user_family.user_id = user_info.user_id
// LEFT JOIN
// organization ON user_info.organization_id = organization.organization_id
// WHERE
// fuser_id = :fuser_id AND user_info.user_id IS NOT NULL
// ");


// $returnData->bindValue(':fuser_id', $_POST['fuser_id'], PDO::PARAM_STR);
// $returnData->execute();
// $returnData =$returnData->fetchAll(\PDO::FETCH_ASSOC);

// echo json_encode($returnData, JSON_UNESCAPED_UNICODE);
?>