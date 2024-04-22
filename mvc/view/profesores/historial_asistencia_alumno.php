<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../styles/historial.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Faltas del Alumno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4ed7db;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        td:nth-child(odd) {
            background-color: #f9f9f9;
        }
        td:nth-child(6) {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Historial del Alumno</h1>
        <a href="../../view/profesores/index.html" class="back-btn">Regresar al Inicio</a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label for="matricula">Buscar por Matrícula:</label>
            <input type="text" id="matricula" name="matricula" placeholder="Ingrese la matrícula del alumno" required>
            <input type="submit" value="Buscar">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matricula'])) {
            $matricula = $_GET['matricula'];

            // Realizar la conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "12345";
            $database = "efi100cia2"; // Reemplaza "tu_base_de_datos" con el nombre real de tu base de datos

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar si la conexión fue exitosa
            if ($conn->connect_error) {
                die("Error en la conexión: " . $conn->connect_error);
            }

            // Consulta SQL para obtener el historial de faltas del alumno por matrícula
            $sql = "SELECT a.id_asistencia, b.nombre AS nombre_asignatura, a.fecha, a.id_grupo, a.hora_entrada, a.asistencia 
                    FROM asistencias a 
                    INNER JOIN asignaturas b ON a.id_asignatura = b.id_asignatura
                    WHERE a.matricula = '$matricula'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Asignatura</th>
                        <th>Fecha</th>
                        <th>Grupo</th>
                        <th>Hora de Entrada</th>
                        <th>Estado</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre_asignatura"] . "</td>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>" . $row["id_grupo"] . "</td>";
                    echo "<td>" . $row["hora_entrada"] . "</td>";
                    echo "<td>" . ($row["asistencia"] == 0 ? "Falta" : "Asistencia") . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No se encontraron registros de asistencia para la matrícula proporcionada.</p>";
            }

            // Cerrar la conexión
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
