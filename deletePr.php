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

 <?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "carcenter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];

// Проверка наличия связанных записей в таблице "Automobil"
$checkAutomobil = "SELECT COUNT(*) FROM automobil WHERE CodProducator = $id";
$resultCheckAutomobil = mysqli_query($conn, $checkAutomobil);

if ($resultCheckAutomobil) {
    $row = mysqli_fetch_assoc($resultCheckAutomobil);
    $countAutomobil = $row['COUNT(*)'];

    // Если есть связанные записи в таблице "Automobil", отменить операцию удаления
    if ($countAutomobil > 0) {
        echo "<div class='container'>";
        echo "<div class='alert alert-warning' role='alert'>";
        echo "Cannot delete the record because there are related records in the 'Automobil' table.";
        
        echo "</div>";
        echo "<a href='show.php' class='btn btn-danger'>Back</a>";
        echo "</div>";
        exit;
    }
} else {
    echo "Error checking related records in the 'Automobil' table: " . mysqli_error($conn);
    exit;
}

// Если нет связанных записей в "Automobil", выполняем операцию удаления в "Producator"
$deleteProducator = "DELETE FROM Producator WHERE CodProducator = $id";
$resultProducator = mysqli_query($conn, $deleteProducator);

if ($resultProducator) {
    echo "<div class='container'>";
    echo "<div class='alert alert-success' role='alert'>";
    echo "Record deleted successfully";
    echo "</div>";
} else {
    echo "Failed to delete record in the producator table: " . mysqli_error($conn);
    
}

?>

<a href="show.php" class="btn btn-danger">Back</a>


</body>
</html>

