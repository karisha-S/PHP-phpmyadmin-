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
    <title>Edit Automobil</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3"
        style="background-color: #889293;  box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        Database CarCenter
    </nav>
    <div class="container1">
        <div class="text-center mb-4">
            <h3>Edit Automobil</h3>
            <p class="text-muted">Complete the form below to edit the car information</p>
        </div>
        <div class="container">
            <div class="d-flex justify-content-center">
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
                $sql = "SELECT * FROM Automobil WHERE CodAutomobil = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
                    <form method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                        <div class="form-floating mt-3 mb-3">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="Model">Model: </label>
                                    <input type="text" class="form-control" id="Model" placeholder="Enter model"
                                        name="Model" value="<?php echo $row['Model']; ?>">
                                </div>
                                <div class="col">
                                    <label for="Marca">Marca: </label>
                                    <input type="text" class="form-control" id="Marca" placeholder="Enter marca"
                                        name="Marca" value="<?php echo $row['Marca']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="Pret">Pret: </label>
                                    <input type="number" class="form-control" id="Pret" placeholder="Enter pret"
                                        name="Pret" value="<?php echo $row['Pret']; ?>">
                                </div>
                                <div class="col">
                                    <label for="NrUsi">Nr Usi: </label>
                                    <input type="number" class="form-control" id="NrUsi" placeholder="Enter nr usi"
                                        name="NrUsi" value="<?php echo $row['NrUsi']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="CodProducator">Cod Producator: </label>
                                    <select class="form-select" id="CodProducator" name="CodProducator">
                                        <?php
                                        // Fetch Producator data
                                        $producatorSql = "SELECT CodProducator, Denumire FROM Producator";
                                        $producatorResult = $conn->query($producatorSql);

                                        while ($producator = $producatorResult->fetch_assoc()) {
                                            $selected = ($producator['CodProducator'] == $row['CodProducator']) ? "selected" : "";
                                            echo "<option value='{$producator['CodProducator']}' $selected>{$producator['Denumire']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="PhotoAuto">Photo automobil: </label>
                                    <input type="file" class="form-control" accept="image/*" id="PhotoAuto"
                                        name="PhotoAuto">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" name="submit">Save Changes</button>
                            <a href="show.php" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    </form>
                    <div class="mt-3">
                <?php
                } else {
                    echo "Car not found.";
                }

              
                if (isset($_POST['submit'])) {
                    $Model = $_POST['Model'];
                    $Marca = $_POST['Marca'];
                    $Pret = $_POST['Pret'];
                    $NrUsi = $_POST['NrUsi'];
                    $CodProducator = $_POST['CodProducator'];

                    $Photo = $_FILES["PhotoAuto"]["name"];
                    $temp_name = $_FILES["PhotoAuto"]["tmp_name"];
                    $folderAuto = "C:/xampp/htdocs/CarCenter/images/" . $Photo;

                    if($Photo == "")
                    {
                        $updateSql = "UPDATE Automobil SET Model='$Model', Marca='$Marca', Pret='$Pret', NrUsi='$NrUsi', CodProducator='$CodProducator' WHERE CodAutomobil='$id'";
                    }else {
                        $uploaddir='./images/';
                        $filename=basename($_FILES['PhotoAuto']['name']);
                        $uploadfile=$uploaddir. $filename;
                        if(!copy($_FILES['PhotoAuto']['tmp_name'],$uploadfile)){
                          echo "<h3>Файл не загружен на сервер...операция прервана</h3>";
                          return;
                        }
                        $updateSql = "UPDATE Automobil SET Model='$Model', Marca='$Marca', Pret='$Pret', NrUsi='$NrUsi', CodProducator='$CodProducator', PhotoAuto='$Photo' WHERE CodAutomobil='$id'";

                    // move_uploaded_file($tmp_name, $folderAuto);

                   

                    }
                    if ($conn->query($updateSql) === TRUE) {
                        echo "<div class='alert alert-success' mt-3 role='alert'>";
                        echo "<p>Record updated successfully</p>";
                        echo "</div>";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>
