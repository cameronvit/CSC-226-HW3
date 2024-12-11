<?php
require 'db.php';

//GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM animals");
    $stmt->execute();
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($animals);
}

//POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("INSERT INTO animals (name, species, age) VALUES (:name, :species, :age)");
    $stmt->execute([
        'name' => $data['name'],
        'species' => $data['species'],
        'age' => $data['age']
    ]);
    echo json_encode(["message" => "Animal added successfully!"]);
}

//PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);
    $stmt = $conn->prepare("UPDATE animals SET name = :name, species = :species, age = :age WHERE id = :id");
    $stmt->execute([
        'name' => $_PUT['name'],
        'species' => $_PUT['species'],
        'age' => $_PUT['age'],
        'id' => $_PUT['id']
    ]);
    echo json_encode(["message" => "Animal updated successfully!"]);
}

//DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $_DELETE);
    $stmt = $conn->prepare("DELETE FROM animals WHERE id = :id");
    $stmt->execute(['id' => $_DELETE['id']]);
    echo json_encode(["message" => "Animal deleted successfully!"]);
}
?>
