<?php
include_once("config.php");
$result = mysqli_query($mysqli, "SELECT * FROM mahasiswa ORDER BY id DESC");
?>

<html>
<head>
    <title>Homepage</title>
</head>
<body>
<a href="add.php">TAMBAHKAN DATA</a><br/><br/>
    <table width='80%' border=1>
    <tr>
        <th>NAMA</th> <th>JENIS KELAMIN</th> <th>PROGRAM STUDI</th> <th>AKSI</th>
    </tr>
    <?php
    while ($user_data = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>".$user_data['NAMA']."</td>";
        echo "<td>".$user_data['JK']."</td>";
        echo "<td>".$user_data['PRODI']."</td>";
        echo "<td><a href='edit.php?id=".$user_data['ID']."'>Edit</a> | <a href='delete.php?id=".$user_data['ID']."'>Delete</a></td>";
    }
    ?>
    </table>
</body>