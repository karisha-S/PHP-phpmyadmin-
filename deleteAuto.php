<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Delete information</title>
</head>

<body>
<nav class="navbar navbar-light justify-content-center fs-3"
     style="background-color: #889293;  box-shadow: 0 0 10px rgba(0,0,0,0.2);">
     Database CarCenter
 </nav>
 <div class="container1">

<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "carcenter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$CodAutomobil = $_GET['id'];


$sqlSelect = "SELECT CodProducator FROM Automobil WHERE CodAutomobil = $CodAutomobil";
$resultSelect = $conn->query($sqlSelect);

if ($resultSelect->num_rows > 0) {
    $row = $resultSelect->fetch_assoc();
    $CodProducător = $row['CodProducator'];


    $sqlDeleteAutomobil = "DELETE FROM Automobil WHERE CodAutomobil = $CodAutomobil";
    $resultDeleteAutomobil = $conn->query($sqlDeleteAutomobil);

    if ($resultDeleteAutomobil) {
       
       
       
        echo "<div class='container'>";
        echo "<div class='alert alert-success' role='alert'>";
        echo "Record deleted successfully";
        echo "</div>";
        
    } else {
        echo "Error deleting record from Automobil: " . $conn->error;
    }
} else {
    echo "No record found with the given CodAutomobil";
}

$conn->close();
?>
 <a href="show.php" class="btn btn-danger">Back</a>
</div>
</body>
</html>