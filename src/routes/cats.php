<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get All cats
$app->get('/api/cats', function(Request $request, Response $response){
    $sql = "SELECT * FROM cats";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single cats
$app->get('/api/cats/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM cats WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add Customer
$app->post('/api/cats/add', function(Request $request, Response $response){
    $name = $request->getParam('name');
    $owner = $request->getParam('owner');
    $age = $request->getParam('age');
    $state = $request->getParam('state');


    $sql = "INSERT INTO cats (name,owner,age,state) VALUES
    (:name,:owner,:phone,:age,:state)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':owner',  $owner);
        $stmt->bindParam(':age',      $age);
        $stmt->bindParam(':state',      $state);


        $stmt->execute();

        echo '{"notice": {"text": "Cat Added"}';


    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update cat
$app->put('/api/cat/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $name = $request->getParam('name');
    $owner = $request->getParam('owner');
    $age = $request->getParam('age');
    $state = $request->getParam('state');


    $sql = "UPDATE cats SET
				name 	= :name,
				owner 	= :owner,
                age		= :age,
                state		= :state
           
			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':owner',  $owner);
        $stmt->bindParam(':age',      $age);
        $stmt->bindParam(':state',      $state);


        $stmt->execute();

        echo '{"notice": {"text": "Cats Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete Cats
$app->delete('/api/cats/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM cats WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Cats Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});