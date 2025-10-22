<html>

<head>
    <title>Tambah Data</title>
</head>

<body>
    <a href="index.php">HALAMAN UTAMA</a>
    <br /><br />
    <form action="add.php" method="post" name="form1">
        <table width="25%" border="0">
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim"></td>
            </tr>
            <td>NAMA</td>
            <td><input type="text" name="nama"></td>
            </tr>
            <tr>
                <td>JENIS KELAMIN</td>
                <td><input type="text" name="jenkel"></td>
            </tr>
            <tr>
                <td>PROGRAM STUDI</td>
                <td><input type="text" name="prodi"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
    <?php
// Check If form submitted, insert form data into users table.
if (isset($_POST['Submit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $prodi = $_POST['prodi'];
    // include database connection file
    include_once("config.php");
    // Insert user data into table
    $result = mysqli_query($mysqli, "INSERT INTO mahasiswa (ID, NAMA, JK, PRODI) VALUES ('$nim', '$nama', '$jenkel', '$prodi')");
    // Show message when user added
    echo "User added successfully. <a href='index.php'>View Users</a>";
}
?>
</body>
</html>