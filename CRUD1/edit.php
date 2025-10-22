<?php
include("config.php");
if (isset($_POST['update'])) {
    $id = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $prodi = $_POST['prodi'];
    // update data mahasiswa
    $result = mysqli_query($mysqli, "UPDATE mahasiswa SET NAMA='$nama', JK='$jenkel', PRODI='$prodi' WHERE ID=$id");
    // menampilkan data pada halaman utama
    header("Location: index.php");
}
// kalau tidak ada id di query string
if (!isset($_GET['id'])) {
    header('Location: index.php');
}
//ambil id dari query string
$nim = $_GET['id'];

// buat query untuk ambil data dari database
$sql = "SELECT * FROM mahasiswa WHERE ID=$nim";
$query = mysqli_query($mysqli, $sql);
$data = mysqli_fetch_assoc($query);

// jika data yang di-edit tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("data tidak ditemukan...");
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User data</title>
</head>

<body>
    <a href="index.php">Home</a>
    <br /><br />
    <form name="update mahasiswa" method="post" action="edit.php">
        <table width="25%" border="0">
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim" readonly value="<?php echo $data['ID'];
                                                                    ?>"></td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td><input type="text" name="nama" value="<?php echo $data['NAMA'] ?>"></td>
            </tr>
            <tr>
                <td>JENIS KELAMIN</td>
                <td><input type="text" name="jenkel" value="<?php echo $data['JK'] ?>"></td>
            </tr>
            <tr>
                <td>PROGRAM STUDI</td>
                <td><input type="text" name="prodi" value="<?php echo $data['PRODI'] ?>"></td>
            </tr>
            <tr>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>

</html>