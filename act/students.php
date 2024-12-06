<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=student_management';
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_GET['action'] ?? '';

    if ($action === 'create') {
        // Create student
        $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, age) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['firstName'], $_POST['lastName'], $_POST['age']]);
        echo json_encode(['message' => 'Student added successfully']);
    } elseif ($action === 'read') {
        // Read students
        $stmt = $pdo->query("SELECT * FROM students");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($action === 'update') {
        // Update student
        $stmt = $pdo->prepare("UPDATE students SET first_name = ?, last_name = ?, age = ? WHERE id = ?");
        $stmt->execute([$_POST['firstName'], $_POST['lastName'], $_POST['age'], $_POST['id']]);
        echo json_encode(['message' => 'Student updated successfully']);
    } elseif ($action === 'delete') {
        // Delete student
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo json_encode(['message' => 'Student deleted successfully']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
