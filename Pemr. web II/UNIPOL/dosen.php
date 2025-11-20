<?php
// dosen.php
require 'config.php';
$home_options = [
    'Teknik Informatika',
    'Sistem Informasi',
    'Manajemen',
    'Akuntansi',
    'Teknik Sipil',
    'PGSD',
    'Magister Manajemen'
];
// Add (fungsi untuk menambahkan data)
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'add'
) {
    $nidn = $_POST['NIDN'];
    $nama = $_POST['Nama'];
    $jk = $_POST['jeniskelamin'];
    $home = $_POST['Homebase'];
    $stmt = $mysqli->prepare("INSERT INTO dosen (NIDN, Nama, jeniskelamin, Homebase) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $nidn, $nama, $jk, $home);
    $stmt->execute();
    header("Location: dosen.php");
    exit;
}
// Edit (fungsi untuk mengedit data)
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'edit'
) {
    $old = $_POST['oldNIDN'];
    $nidn = $_POST['NIDN'];
    $nama = $_POST['Nama'];
    $jk = $_POST['jeniskelamin'];
    $home = $_POST['Homebase'];
    $stmt = $mysqli->prepare("UPDATE dosen SET NIDN=?, Nama=?, jeniskelamin=?,
Homebase=? WHERE NIDN=?");
    $stmt->bind_param('sssss', $nidn, $nama, $jk, $home, $old);
    $stmt->execute();
    header("Location: dosen.php");
    exit;
}
// Delete (fungsi untuk menghapus data)
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM dosen WHERE NIDN=?");
    $stmt->bind_param('s', $del);
    $stmt->execute();
    header("Location: dosen.php");
    exit;
}
// Prefill edit (fungsi untuk memperbaharui data yang telah diisi sebelumnya)
$editData = null;
$editData = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $mysqli->prepare("SELECT * FROM dosen WHERE NIDN=?");
    $res->bind_param('s', $id);
    $res->execute();
    $editData = $res->get_result()->fetch_assoc();
}
// Fetch all (metode untuk mengambil semua data sekaligus dari database)
$resultAll = $mysqli->query("SELECT * FROM dosen ORDER BY Nama ASC");
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Dosen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Data Dosen</h2>
            <nav>
                <a href="index.php">Beranda</a>
                <a href="mahasiswa.php">Mahasiswa</a>
                <a href="matakuliah.php">Mata Kuliah</a>
                <a href="jadwal.php">Jadwal</a>
            </nav>
        </div>
        <?php if ($editData): ?>
            <h3>Edit Dosen (NIDN: <?php echo htmlspecialchars($editData['NIDN']); ?>)</h3>
            <form method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="oldNIDN" value="<?php echo
                                                            htmlspecialchars($editData['NIDN']); ?>">
                <div class="form-row"><label>NIDN</label><input class="input" name="NIDN" required value="<?php echo htmlspecialchars($editData['NIDN']); ?>"></div>
                <div class="form-row"><label>Nama</label><input class="input" name="Nama"
                        required value="<?php echo htmlspecialchars($editData['Nama']); ?>"></div>
                <div class="form-row">
                    <label>Jenis Kelamin</label>
                    <label class="flex"><input type="radio" name="jeniskelamin" value="Laki-Laki"
                            <?php if ($editData['jeniskelamin'] == 'Laki-Laki') echo 'checked'; ?>> Laki-Laki</label>
                    <label class="flex"><input type="radio" name="jeniskelamin" value="Perempuan"
                            <?php if ($editData['jeniskelamin'] == 'Perempuan') echo 'checked'; ?>> Perempuan</label>
                </div>
                <div class="form-row">
                    <label>Homebase</label>
                    <select name="Homebase" class="input" required>
                        <?php foreach ($home_options as $h): ?>
                            <option <?php if ($editData['Homebase'] == $h) echo 'selected'; ?>><?php
                                                                                                echo $h; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="dosen.php">Batal</a>
            </form>
        <?php else: ?>
            <h3>Tambah Dosen</h3>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="form-row"><label>NIDN</label><input class="input" name="NIDN"
                        required> </div>
                <div class="form-row"><label>Nama</label><input class="input" name="Nama"
                        required> </div>
                <div class="form-row">
                    <label>Jenis Kelamin</label>
                    <label class="flex"><input type="radio" name="jeniskelamin" value="Laki-Laki"
                            required> Laki-Laki</label>
                    <label class="flex"><input type="radio" name="jeniskelamin" value="Perempuan">
                        Perempuan</label>
                </div>
                <div class="form-row">
                    <label>Homebase</label>
                    <select name="Homebase" class="input" required>
                        <?php foreach ($home_options as $h): ?>
                            <option><?php echo $h; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Tambah</button>
            </form>
        <?php endif; ?>
        <h3>Daftar Dosen</h3>
        <table>
            <thead>
                <tr>
                    <th>NIDN</th>
                    <th>Nama</th>
                    <th>Jenis
                        Kelamin</th>
                    <th>Homebase</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultAll->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['NIDN']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['JenisKelamin']); ?></td> <!-- SESUAI NAMA ASLI -->
                        <td><?php echo htmlspecialchars($row['Homebase']); ?></td>
                        <td class="actions">
                            <a href="dosen.php?edit=<?php echo urlencode($row['NIDN']); ?>">Edit</a>
                            <a href="dosen.php?delete=<?php echo urlencode($row['NIDN']); ?>"
                                onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>