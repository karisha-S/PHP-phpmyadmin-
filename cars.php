<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show information</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-1" style="background-color:#889293; box-shadow: 0 0 10px rgba(0,0,0,0.2);">
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

$manufacturersSql = "SELECT * FROM Producator";
$manufacturersResult = $conn->query($manufacturersSql);



if ($manufacturersResult->num_rows > 0) {
    while ($manufacturer = $manufacturersResult->fetch_assoc()) {
        $manufacturerId = $manufacturer['CodProducator'];
        $manufacturerName = $manufacturer['Denumire'];
        echo"  <div class='container1'>";
echo"  <div class='container'>";

        echo "<h4 class='mt-3'>$manufacturerName</h4>";

        $carsSql = "SELECT * FROM Automobil WHERE CodProducator = $manufacturerId";
        $carsResult = $conn->query($carsSql);

        if ($carsResult->num_rows > 0) {
            ?>
          
          <table class="table table-striped">
            <thead>
              <tr>
            <th>Model</th>
            <th>Pret</th>
          </tr>
        </thead>
        <tbody>
        </div>
<?php
            $totalCost = 0;

            while ($car = $carsResult->fetch_assoc()) {
                $model = $car['Model'];
                $price = $car['Pret'];

                echo "<tr>";
                echo "<td>$model</td>";
                echo "<td>$price</td>";
                echo "</tr>";

                $totalCost += $price;
            }

            echo "</tbody>";
            echo "</table>";
           

            echo "<p>Total Cost: $totalCost</p>";
            echo "</div>";
        } else {
            echo "<p>No cars found for $manufacturerName</p>";

            
        }
    }
} else {
    echo "<p>No manufacturers found</p>";
    echo "</div>";
}

$conn->close();
?>
     <center><a href="show.php" class="btn btn-danger">Back</a></center>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-cs9a6YpTTIaHMO8pMhBL8sm/Z9ndQ4FgcDh3SQ6t3LqJMF83dpn5ebqNKE02W0fD" crossorigin="anonymous"></script>
</body>
</html>
