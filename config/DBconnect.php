<?
$host = 'localhost';
$dbname = '2024busanskills';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
