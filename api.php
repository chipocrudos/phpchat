<?php
require "Slim/Slim.php";
\Slim\Slim::registerAutoloader();
use Slim\Slim;
$app = new \Slim\Slim();

$app->get('/', 'getHome');
$app->get('/hello/:name', 'getHello');
#Usuarios
$app->get('/user/', 'getUsers');
$app->get('/user/:id', 'getUser');
$app->post('/user/', 'addUser');
#$app->put('/user/:id', 'updateUser');
$app->delete('/user/:id', 'deleteUser');
#Linesas chat
$app->get('/line/:id', 'getLines');
$app->post('/line/', 'addLine');
#$app->config('debug', true);
$app->run();

function getHome() {
    echo "running api";
}

function getHello($name) {
    echo "Hola ".$name;
}

function getUsers() {
    $sql = "select * FROM phpchat.user ORDER BY id";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($users);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function addUser() {
    $request = Slim::getInstance()->request();
    $user = json_decode($request->getBody());
    $sql = "INSERT INTO user (nick, urlimg) VALUES (:nick, :urlimg)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nick", $user->nick);
        $stmt->bindParam("urlimg", $user->urlimg);
        $stmt->execute();
        $user->id = $db->lastInsertId();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getUser($id) {
    $sql = "select * FROM user WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function deleteUser($id) {
    echo '{"error":{"text":"eliminado"}}';
    $request = Slim::getInstance()->request();
    $sql = "DELETE FROM user WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getLines($id) {
    $sql = "select * from phpchat.lines where id>=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $lines = $stmt->fetchAll(PDO::FETCH_OBJ);
        #$lines = $stmt->fetchObject();
        $db = null;
        echo json_encode($lines);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function addLine() {
    $request = Slim::getInstance()->request();
    $line = json_decode($request->getBody());
    $sql = "INSERT INTO phpchat.lines (nick, urlimg, msg) VALUES (:nick, :urlimg, :msg)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nick", $line->nick);
        $stmt->bindParam("urlimg", $line->urlimg);
        $stmt->bindParam("msg", $line->msg);
        $stmt->execute();
        $line->id = $db->lastInsertId();
        $db = null;
        echo json_encode($line);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getConnection() {
    $dbhost="localhost";
    $dbname="phpchat";
    $dbuser="root";
    $dbpass="contrasena.mysql";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}


?>
