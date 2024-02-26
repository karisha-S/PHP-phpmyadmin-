<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Automobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-light justify-content-center fs-3" style="background-color: #889293;  box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        Database CarCenter
    </nav>
    <div class="container1">
        <div class="text-center mb-4">
            <h3>Add New Automobile</h3>
            <p class="text-muted">Complete the form below to add a new car</p>
        </div>
        <div class="container">
            <div class="d-flex justify-content-center">
                <form action="addAuto.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                    <div class="form-floating mt-3 mb-3">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Model">Model: </label>
                                <input type="text" class="form-control" id="Model" placeholder="Enter model" name="Model">
                            </div>
                            <div class="col">
                                <label for="Marca">Marca: </label>
                                <input type="text" class="form-control" id="Marca" placeholder="Enter marca" name="Marca">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Pret">Price: </label>
                                <input type="number" class="form-control" id="Pret" placeholder="Enter price" name="Pret">
                            </div>
                            <div class="col">
                                <label for="NrUsi">NrUsi: </label>
                                <input type="number" class="form-control" id="NrUsi" placeholder="Enter number of doors" name="NrUsi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="CodProducator">Producator: </label>
                                <select class="form-select" id="CodProducator" name="CodProducator">
                                    <!-- Fetch and populate this dropdown dynamically from the Producator table -->
                                    <?php
                                    $servername = "localhost:3307";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "carcenter";

                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT CodProducator, Denumire FROM Producator";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['CodProducator'] . "'>" . $row['Denumire'] . "</option>";
                                        }
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="PhotoAuto">Car Photo: </label>
                                <input type="file" class="form-control" accept="image/*" id="PhotoAuto" name="PhotoAuto">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                    <a href="show.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "carcenter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Model = isset($_POST['Model']) ? $_POST['Model'] : '';
    $Marca = isset($_POST['Marca']) ? $_POST['Marca'] : '';
    $Pret = isset($_POST['Pret']) ? $_POST['Pret'] : '';
    $NrUsi = isset($_POST['NrUsi']) ? $_POST['NrUsi'] : '';
    $CodProducator = isset($_POST['CodProducator']) ? $_POST['CodProducator'] : '';


    if (isset($_FILES["PhotoAuto"]) && $_FILES["PhotoAuto"]["error"] == UPLOAD_ERR_OK) {
        $PhotoAuto = $_FILES["PhotoAuto"]["name"];
        $tempnameAuto = $_FILES["PhotoAuto"]["tmp_name"];
        $folderAuto = "C:/xampp/htdocs/CarCenter/images/" . $PhotoAuto;

     
        move_uploaded_file($tempnameAuto, $folderAuto);
    } else {
      
        echo "<div class='alert alert-danger' role='alert'>";
        echo "Error uploading file.";
        echo "</div>";
        exit(); 
    }

 
    $checkProducator = "SELECT CodProducator FROM Producator WHERE CodProducator = '$CodProducator'";
    $resultProducator = $conn->query($checkProducator);

    if ($resultProducator->num_rows == 0) {
    
        echo "<div class='alert alert-danger' role='alert'>";
        echo "Invalid Producator selected.";
        echo "</div>";
        exit(); 
    }

    $sql = "INSERT INTO Automobil (Model, Marca, Pret, NrUsi, CodProducator, PhotoAuto)
            VALUES ('$Model', '$Marca', '$Pret', '$NrUsi', '$CodProducator', '$PhotoAuto')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>";
        echo "New record created successfully";
        echo "</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
</body>
</html>