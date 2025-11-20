<?php
// mahasiswa.php
require 'config.php';
$prodi_options = [
    'Teknik Informatika',
    'Sistem Informasi',
    'Manajemen',
    'Akuntansi',
    'Teknik Sipil',
    'PGSD',
    'Magister Manajemen'
];
// Handle Add (Fungsi Untuk Menyimpan Data Mahasiswa yang telah diinput)
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'add'
) {
    $nim = $_POST['Nim'];
    $nama = $_POST['Nama'];
    $prodi = $_POST['Prodi'];
    $jk = $_POST['JenisKelamin'];
    $angkatan = $_POST['Angkatan'];
    $stmt = $mysqli->prepare("INSERT INTO mahasiswa (Nim, Nama, Prodi, jeniskelamin,
Angkatan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $nim, $nama, $prodi, $jk, $angkatan);
    $stmt->execute();
    header("Location: mahasiswa.php");
    exit;
}
// Handle Edit (Fungsi untuk mengedit Data Mahasiswa)
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'edit'
) {
    $old = $_POST['oldNim'];
    $nim = $_POST['Nim'];
    $nama = $_POST['Nama'];
    $prodi = $_POST['Prodi'];
    $jk = $_POST['jeniskelamin'] ?? '';
    $angkatan = $_POST['Angkatan'];
    $stmt = $mysqli->prepare("UPDATE mahasiswa SET Nim=?, Nama=?, Prodi=?, jeniskelamin=?,
Angkatan=? WHERE Nim=?");
    $stmt->bind_param('ssssss', $nim, $nama, $prodi, $jk, $angkatan, $old);
    $stmt->execute();
    header("Location: mahasiswa.php");
    exit;
}
// Handle Delete (Fungsi untuk menghapus data Mahasiswa)
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM mahasiswa WHERE Nim=?");
    $stmt->bind_param('s', $del);
    $stmt->execute();
    header("Location: mahasiswa.php");
    exit;
}
// For Edit form prefill (fungsi untuk memperbaharui data yang telah diisi sebelumnya)
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $mysqli->prepare("SELECT * FROM mahasiswa WHERE Nim=?");
    $res->bind_param('s', $id);
    $res->execute();
    $result = $res->get_result();
    $editData = $result->fetch_assoc();
}
// Fetch all (metode untuk mengambil semua data sekaligus dari database)
$resultAll = $mysqli->query("SELECT * FROM mahasiswa ORDER BY Angkatan DESC, Nama
ASC");
?>
<!--Membuat Form Mahasiswa (Terintegrasi Fungsi Simpan, Edit dan Hapus Data dalam satu
Form) -->
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Data Mahasiswa</h2>
            <nav>
                <a href="index.php">Beranda</a>
                <a href="dosen.php">Dosen</a>
                <a href="matakuliah.php">Mata Kuliah</a>
                <a href="jadwal.php">Jadwal</a>
            </nav>
        </div>
        <!-- Membuat form Edit data mahasiswa -->
        <?php if ($editData): ?>
            <h3>Edit Mahasiswa (NIM: <?php echo htmlspecialchars($editData['Nim']); ?>)</h3>
            <form method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="oldNim" value="<?php echo
                                                            htmlspecialchars($editData['Nim']); ?>">
                <div class="form-row">
                    <label>NIM</label>
                    <input class="input" name="Nim" required value="<?php echo
                                                                    htmlspecialchars($editData['Nim']); ?>">
                </div>
                <div class="form-row">
                    <label>Nama</label>
                    <input class="input" name="Nama" required value="<?php echo
                                                                        htmlspecialchars($editData['Nama']); ?>">
                </div>
                <div class="form-row">
                    <label>Prodi</label>
                    <select name="Prodi" class="input" required>
                        <?php foreach ($prodi_options as $p): ?>
                            <option <?php if ($editData['Prodi'] == $p) echo 'selected'; ?>><?php echo
                                                                                            $p; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label>Jenis Kelamin</label>
                    <label class="flex">
                        <input type="radio" name="jeniskelamin" value="Laki-laki"
                            <?= (isset($editData['jeniskelamin']) && $editData['jeniskelamin'] === 'Laki-laki') ? 'checked' : '' ?>>
                        Laki-laki
                    </label>
                    <label class="flex">
                        <input type="radio" name="jeniskelamin" value="Perempuan"
                            <?= (isset($editData['jeniskelamin']) && $editData['jeniskelamin'] === 'Perempuan') ? 'checked' : '' ?>>
                        Perempuan
                    </label>
                </div>

                <div class="form-row">
                    <label>Angkatan (YYYY)</label>
                    <input class="input" name="Angkatan" required value="<?= htmlspecialchars($editData['Angkatan'] ?? '') ?>">
                </div>

                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                <a class="btn btn-secondary" href="mahasiswa.php">Batal</a>
            </form>
            <!-- Membuat form tambah data mahasiswa -->
        <?php else: ?>
            <h3>Tambah Mahasiswa</h3>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="form-row">
                    <label>NIM</label>
                    <input class="input" name="Nim" required>
                </div>
                <div class="form-row">
                    <label>Nama</label>
                    <input class="input" name="Nama" required>
                </div>
                <div class="form-row">
                    <label>Prodi</label>
                    <select name="Prodi" class="input" required>
                        <?php foreach ($prodi_options as $p): ?>
                            <option><?php echo $p; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label class="flex">
                    <input type="radio" name="JenisKelamin" value="Laki-laki"
                        <?= (isset($_POST['JenisKelamin']) && $_POST['JenisKelamin'] === 'Laki-laki') ? 'checked' : '' ?>>
                    Laki-laki
                </label>

                <label class="flex">
                    <input type="radio" name="jeniskelamin" value="Perempuan"
                        <?= (isset($_POST['JenisKelamin']) && $_POST['JenisKelamin'] === 'Perempuan') ? 'checked' : '' ?>>
                    Perempuan
                </label>

                <div class="form-row">
                    <label>Angkatan (YYYY)</label>
                    <input class="input" name="Angkatan" required>
                </div>
                <button class="btn btn-primary" type="submit">Tambah</button>
            </form>
        <?php endif; ?>
        <!-- Membuat Tabel dan menampilkan data mahasiswa -->
        <h3>Daftar Mahasiswa</h3>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Jenis
                        Kelamin</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultAll->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Nim'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Nama'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Prodi'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($row['JenisKelamin']); ?></td>
                        <td><?= htmlspecialchars($row['Angkatan'] ?? '') ?></td>
                        <td class="actions">
                            <a href="mahasiswa.php?edit=<?= urlencode($row['Nim'] ?? '') ?>">Edit</a>
                            <a href="mahasiswa.php?delete=<?= urlencode($row['Nim'] ?? '') ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>