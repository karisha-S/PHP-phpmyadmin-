<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-1" style="background-color:#889293; box-shadow: 0 0 10px rgba(0,0,0,0.2);">
    Database CarCenter
</nav>

<div class="container1">
    <h2 class="text-center">Show table</h2>

    <form method="get" class="mb-3">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="table" class="form-label">Select Table:</label>
                <div class="input-group">
                    <select class="form-select" id="table" name="table">
                        <option value="Automobil">Automobil</option>
                        <option value="Producator">Producator</option>
                    </select>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <div class="col-md-4">
                <label for="max_pret" class="form-label">Max price:</label>
                <div class="input-group">
                    <input type="number" min="100" class="form-control" name="max_pret" id="max_pret" placeholder="Enter max pret">
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <!-- Выбор производителя -->
            <div class="col-md-4">
                <label for="manufacturer" class="form-label">Select Producator:</label>
                <div class="input-group">
                    <select class="form-select" id="manufacturer" name="manufacturer">
                        <option value="" selected disabled>Choose Producator</option>

                        <?php

                        $servername = "localhost:3307";
                        $username = "root";
                        $password = "";
                        $dbname = "carcenter";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT CodProducator, Denumire FROM producator";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["CodProducator"] . "'>" . $row["Denumire"] . "</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>


                    <a href="cars.php?manufacturer=<?php echo htmlspecialchars($_GET['manufacturer'] ?? ''); ?>" class="btn btn-outline-secondary">Total cost of all cars</a>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <?php
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "carcenter";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $table = $_GET['table'] ?? 'Automobil';

        $sql = "SELECT * FROM $table";

        if (isset($_GET['show']) && $_GET['show'] == 'true') {
            $result = $conn->query($sql);
        } else {
            $conditions = [];

            if (!empty($_GET['max_pret'])) {
                $conditions[] = "Pret <= " . $_GET['max_pret'];
            }

            if (!empty($_GET['manufacturer'])) {
                $manufacturerId = $_GET['manufacturer'];
                $conditions[] = "CodProducator = '$manufacturerId'";
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            $result = $conn->query($sql);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-3'>";

                if ($table == 'Automobil') {
                    echo "<div class='container'>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Photo Auto: </b><img src='images/" . $row["PhotoAuto"] . "' style='width: 100%; height: 200px; object-fit: cover;' alt='Automobil'></p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Model: </b>" . $row["Model"] . "</p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Marca: </b>" . $row["Marca"] . "</p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Pret: </b>" . $row["Pret"] . "</p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Nr Usi: </b>" . $row["NrUsi"] . "</p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- CodProducator: </b>" . $row["CodProducator"] . "</p>";
                    echo "</div>";
                    echo "<p>";
                    echo "<a href='editAuto.php?id=" . $row["CodAutomobil"] . "' class='link-dark'><i class='fa-solid fa-pen-to-square fs-5 me-3'></i></a>";
                    echo "<a href='deleteAuto.php?id=" . $row["CodAutomobil"] . "' class='link-dark'><i class='fa-solid fa-trash fs-5 me-3'></i></a>";
                    echo "<a href='addAuto.php' class='btn btn-dark mb-3'>Add New</a>";
                    echo "</p>";

                    echo "</div>";
                    echo "<div class='container1'>";
                    echo "</div>";

                } elseif ($table == 'Producator') {
                    echo "<div class='container1'>";
                    echo "<div class='container'>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Photo Producator: </b><img src='images/" . $row["PhotoPr"] . "' style='width: 100%; height: 200px; object-fit: cover;' alt='Producator'></p>";

                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Denumire: </b>" . $row["Denumire"] . "</p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- Tara: </b>" . $row["Tara"] . "</p>";
                    echo "</div>";
                    echo "<div class='text-zoom'>";
                    echo "<p><b>- WebAdresa: </b>" . $row["WebAdresa"] . "</p>";
                    echo "</div>";
                    echo "<p>";
                    echo "<a href='deletePr.php?id=" . $row["CodProducator"] . "' class='link-dark'><i class='fa-solid fa-trash fs-5 me-3'></i></a>";
                    echo "<a href='editPr.php?id=" . $row["CodProducator"] . "' class='link-dark'><i class='fa-solid fa-pen-to-square fs-5 me-3'></i></a>";
                    echo "<a href='addPr.php' class='btn btn-dark mb-3'>Add New</a>";
                    echo "</p>";
                    echo "</div>";


                    echo "</div>";
                }


                echo "</div>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
        <div class='container1'>

        </div>
    </div>
</div>
</body>
</html>
