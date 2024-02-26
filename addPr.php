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
    <title>Add information</title>
</head>

<body>
    
    <nav class="navbar navbar-light justify-content-center fs-3"
        style="background-color: #889293;  box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        Database CarCenter
    </nav>
    <div class="container1">
        <div class="text-center mb-4">
            <h3>Add New Producator</h3>
            <p class="text-muted">Complete the form below to add a new producator</p>
        </div>
        <div class="container1">
        <div class="container">
            <div class="d-flex justify-content-center">
                <form  method="post" enctype="multipart/form-data"style="width:50vw; min-width:300px;">
                    <div class="form-floating mt-3 mb-3">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Denumire">Denumire: </label>
                                <input type="text" class="form-control" id="Denumire" placeholder="Enter denumire"  name="Denumire">
                            </div>
                            <div class="col">
                                <label for="Tara">Tara: </label>
                                <input type="text" class="form-control" id="Tara" placeholder="Enter tara"name="Tara">
                            </div>
                        </div>
                        <div class="form-floating mt-3 mb-3">
                            <div class="col">
                            <label class="form-label" for="WebAdresa">WebAdresa: </label>
                            <input type="text" class="form-control" id="WebAdresa" placeholder="Enter WebAdresa" name="WebAdresa">

                            </div>
                        </div>
                        <div class="form-floating mt-3 mb-3">
                            <div class="col">
                            <label class="form-label" for="PhotoPr">Photo Producator: </label>
                            <input type="file" class="form-control" accept="image/*" id="PhotoPr" name="PhotoPr">
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
    $Denumire = isset($_POST['Denumire']) ? $_POST['Denumire'] : '';
    $Tara = isset($_POST['Tara']) ? $_POST['Tara'] : '';
    $WebAdresa = isset($_POST['WebAdresa']) ? $_POST['WebAdresa'] : '';

    if (isset($_FILES["PhotoPr"]) && $_FILES["PhotoPr"]["error"] == UPLOAD_ERR_OK) {
        $PhotoPr = $_FILES["PhotoPr"]["name"];
        $tempnamePr = $_FILES["PhotoPr"]["tmp_name"];
        $folderPr = "C:/xampp/htdocs/CarCenter/images/" . $PhotoPr;

        move_uploaded_file($tempnamePr, $folderPr);
    } else {
     
        echo "<div class='alert alert-danger' role='alert'>";
        echo "Error uploading file.";
        echo "</div>";
        exit(); 
    }

    $sql = "INSERT INTO Producator (Denumire, Tara, WebAdresa, PhotoPr)
            VALUES ('$Denumire', '$Tara', '$WebAdresa', '$PhotoPr')";

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









































