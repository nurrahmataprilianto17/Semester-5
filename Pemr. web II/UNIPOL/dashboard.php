<?php
// koneksi.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'unipol';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>

<!-- dashboard.php -->
<?php include 'config.php'; ?>
<?php
$mahasiswa = $conn->query("SELECT COUNT(*) AS total FROM mahasiswa")->fetch_assoc();
$dosen     = $conn->query("SELECT COUNT(*) AS total FROM dosen")->fetch_assoc();
$matkul    = $conn->query("SELECT COUNT(*) AS total FROM matakuliah")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Panel</title>
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #f5f7fb;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #1e1f26;
            color: #fff;
            padding: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar a {
            color: #cfd1d6;
            text-decoration: none;
            padding: 10px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #2c2e36;
            color: #fff;
        }

        .main {
            margin-left: 260px;
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card h3 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .card p {
            margin-top: 10px;
            font-size: 30px;
            font-weight: bold;
            color: #4c6ef5;
        }

        .header {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="#">Beranda</a>
        <a href="#">Mahasiswa</a>
        <a href="#">Dosen</a>
        <a href="#">Mata Kuliah</a>
        <a href="#">Pengaturan</a>
    </div>

    <div class="main">
        <div class="header">Panel Data Akademik</div>

        <div class="cards">
            <div class="card">
                <h3>Data Mahasiswa</h3>
                <p><?php echo $mahasiswa['total']; ?></p>
            </div>

            <div class="card">
                <h3>Data Dosen</h3>
                <p><?php echo $dosen['total']; ?></p>
            </div>

            <div class="card">
                <h3>Mata Kuliah</h3>
                <p><?php echo $matkul['total']; ?></p>
            </div>
        </div>
    </div>
</body>

</html>