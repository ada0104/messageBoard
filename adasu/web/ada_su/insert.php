<?php
require 'vendor/autoload.php';

$db = new DBCONNET();

$method = $_SERVER['REQUEST_METHOD'];
if (!isset($method)) {
    return ['未帶入REQUEST_METHOD'];
};
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['name'])){
        return ['未帶入正確參數name'];
    };
    if (!isset($_POST['context'])) {
        return ['未帶入正確參數context'];
    };
    $name = $_POST['name'];
    $context = $_POST['context'];
    $name = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $name));
    $context = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $context));
    echo json_encode(insert($name, $context));
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_SERVER['QUERY_STRING'];
    if (!isset($id)) {
        return ['未帶入正確參數'];
    };
    $id = htmlspecialchars(preg_replace('/[^\d]/', '', $id));
    echo json_encode(delete($id));
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);
    if (!isset($_PUT['updateId'])) {
        return ['未帶入正確參數Id'];
    };
    if (!isset($_PUT['updateName'])) {
        return ['未帶入正確參數Name'];
    };
    if (!isset($_PUT['updateContext'])) {
        return ['未帶入正確參數Context'];
    };
    $updateId =  $_PUT['updateId'];
    $updateName = $_PUT['updateName'];
    $updateContext =  $_PUT['updateContext'];
    $updateId = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $updateId));
    $updateName = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $updateName));
    $updateContext = htmlspecialchars(preg_replace("/[\'\"]+/" , '', $updateContext));
    echo json_encode(edit($updateId, $updateName, $updateContext));
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(view());
};

function view() {
    try {
        global $conn;
        $sql = 'SELECT id,name,context FROM context ORDER BY context.id ASC';
        $returnData = $conn->prepare($sql);
        $returnData->execute();
        $returnData =$returnData->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($returnData, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        die("Something wrong: {$e->getMessage()}");
    }
};
function insert($name,$context) {
    try {
        global $conn;
        $sql = 'INSERT INTO context (id, name, context, other)
                VALUES (NULL, :name, :context, " ")';
        $returnData = $conn->prepare($sql);
        $returnData->bindValue(':name', $name, PDO::PARAM_STR);
        $returnData->bindValue(':context', $context, PDO::PARAM_STR);
        $returnData->execute();
        return ['新增成功'];
    } catch (PDOException $e) {
        die ("Something wrong: {$e->getMessage()}");
    }
};
function delete($id) {
    try {
        global $conn;
        $sql ='SELECT EXISTS(SELECT * FROM context WHERE id = :id)';
        $returnData = $conn->prepare($sql);
        $returnData->bindValue(':id', $id, PDO::PARAM_STR);
        $returnData->execute();
        if (!$returnData) {
            return ['無此筆資料'];
        }
        $sql = 'DELETE FROM context WHERE context.id = :id';
        $returnData = $conn->prepare($sql);
        $returnData->bindValue(':id', $id, PDO::PARAM_STR);
        $returnData->execute();
        return ['刪除成功'];
    } catch (PDOException $e) {
        die ("Something wrong: {$e->getMessage()}");
    }
};
function edit($updateId, $updateName, $updateContext) {
    try {
        global $conn;
        $sql ='SELECT EXISTS(SELECT * FROM context WHERE id = :updateId)';
        $returnData = $conn->prepare($sql);
        $returnData->bindValue(':updateId', $updateId, PDO::PARAM_STR);
        $returnData->execute();
        if (!$returnData) {
            return ['無此筆資料'];
        }
        $sql = 'UPDATE context
                SET name = :updateName, context = :updateContext
                WHERE context.id = :updateId';
        $returnData = $conn->prepare($sql);
        $returnData->bindValue(':updateId', $updateId, PDO::PARAM_STR);
        $returnData->bindValue(':updateName', $updateName, PDO::PARAM_STR);
        $returnData->bindValue(':updateContext', $updateContext, PDO::PARAM_STR);
        $returnData->execute();
        return ['修改成功'];
    } catch (PDOException $e) {
        die ("Something wrong: {$e->getMessage()}");
    }
}

