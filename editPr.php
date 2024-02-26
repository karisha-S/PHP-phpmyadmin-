<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "carcenter";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];

if (isset($_POST["submit"])) {
    $denumire = $_POST['denumire'];
    $tara = $_POST['tara'];
    $webAdresa = $_POST['webAdresa'];
    $photo = $_FILES["photo"]["name"];
    $tmp_name = $_FILES["photo"]["tmp_name"];
    $folder = "C:/xampp/htdocs/CarCenter/image" . $photo;

    if($photo == ""){
        $sql = "UPDATE `Producator` SET `Denumire`='$denumire',`Tara`='$tara',`WebAdresa`='$webAdresa' WHERE CodProducator =$id";
    }else {
        $uploaddir='./images/';
        $filename=basename($_FILES['photo']['name']);
        $uploadfile=$uploaddir. $filename;
        if(!copy($_FILES['photo']['tmp_name'],$uploadfile)){
          echo "<h3>Файл не загружен на сервер...операция прервана</h3>";
          return;
        }
    
    $sql = "UPDATE `Producator` SET `Denumire`='$denumire',`Tara`='$tara',`WebAdresa`='$webAdresa',`PhotoPr`='$photo' WHERE CodProducator =$id";
    }
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: show.php?msg=Data updated successfully");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Edit information</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 "
        style="background-color: #889293;  box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        Database CarCenter
    </nav>
    <div class="container1">
        <div class="container">
            <div class="text-center mb-4">
                <h3>Edit Producer Information</h3>
                <p class="text-muted">Click update after changing any information</p>
            </div>

            <?php
            $sql = "SELECT * FROM `Producator` WHERE CodProducator = $id LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            ?>

            <div class="d-flex justify-content-center">
                <form action="" method="post" style="width:50vw; min-width:300px;" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Denumire:</label>
                            <input type="text" class="form-control" name="denumire" value="<?php echo $row['Denumire'] ?>">
                        </div>

                        <div class="col">
                            <label class="form-label">Tara:</label>
                            <input type="text" class="form-control" name="tara" value="<?php echo $row['Tara'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Web Adresa:</label>
                            <input type="text" class="form-control" name="webAdresa"
                                value="<?php echo $row['WebAdresa'] ?>">
                        </div>

                        <div class="col">
                            <label class="form-label">Photo:</label>

                            <img src="<?php echo $row["PhotoPr"]; ?>" alt="Current Photo" width="60%">
                            <input type="file" class="form-control" accept="image/*" name="photo">

                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                        <a href="show.php" class="btn btn-danger">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
    <div class="container1">
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>

</body>

</html>
