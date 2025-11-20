<?php
// matakuliah.php
require 'config.php';
// Add
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'add'
) {
    $kode = $_POST['kodeMK'];
    $nama = $_POST['MataKuliah'];
    $sks = intval($_POST['SKS']);
    $stmt = $mysqli->prepare("INSERT INTO matakuliah (kodeMK, MataKuliah, SKS)
VALUES (?, ?, ?)");
    $stmt->bind_param('ssi', $kode, $nama, $sks);
    $stmt->execute();
    header("Location: matakuliah.php");
    exit;
}

// Edit
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'edit'
) {
    $old = $_POST['oldKode'];
    $kode = $_POST['kodeMK'];
    $nama = $_POST['MataKuliah'];
    $sks = intval($_POST['SKS']);
    $stmt = $mysqli->prepare("UPDATE matakuliah SET kodeMK=?, MataKuliah=?, SKS=?
WHERE kodeMK=?");
    $stmt->bind_param('ssis', $kode, $nama, $sks, $old);
    $stmt->execute();
    header("Location: matakuliah.php");

    exit;
}
// Delete
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM matakuliah WHERE kodeMK=?");
    $stmt->bind_param('s', $del);
    $stmt->execute();
    header("Location: matakuliah.php");
    exit;
}

// Prefill edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $mysqli->prepare("SELECT * FROM matakuliah WHERE kodeMK=?");
    $res->bind_param('s', $id);
    $res->execute();
    $editData = $res->get_result()->fetch_assoc();
}

// Fetch all
$resultAll = $mysqli->query("SELECT * FROM matakuliah ORDER BY MataKuliah ASC");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Mata Kuliah</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Data Mata Kuliah</h2>
            <nav>
                <a href="index.php">Beranda</a>
                <a href="mahasiswa.php">Mahasiswa</a>
                <a href="dosen.php">Dosen</a>
                <a href="jadwal.php">Jadwal</a>
            </nav>
        </div>

        <?php if ($editData): ?>
            <h3>Edit Mata Kuliah (Kode: <?php echo
                                        htmlspecialchars($editData['kodeMK']); ?>)</h3>
            <form method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="oldKode" value="<?php echo
                                                            htmlspecialchars($editData['kodeMK']); ?>">

                <div class="form-row"><label>Kode MK</label><input class="input"
                        name="kodeMK" required value="<?php echo
                                                        htmlspecialchars($editData['kodeMK']); ?>"></div>
                <div class="form-row"><label>Mata Kuliah</label><input class="input"
                        name="MataKuliah" required value="<?php echo
                                                            htmlspecialchars($editData['MataKuliah']); ?>"></div>
                <div class="form-row"><label>SKS</label><input class="input" name="SKS"
                        type="number" min="0" required value="<?php echo
                                                                htmlspecialchars($editData['SKS']); ?>"></div>
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="matakuliah.php">Batal</a>
            </form>
        <?php else: ?>
            <h3>Tambah Mata Kuliah</h3>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="form-row"><label>Kode MK</label><input class="input"
                        name="kodeMK" required></div>
                <div class="form-row"><label>Mata Kuliah</label><input class="input"
                        name="MataKuliah" required></div>
                <div class="form-row"><label>SKS</label><input class="input" name="SKS"
                        type="number" min="0" required></div>
                <button class="btn btn-primary" type="submit">Tambah</button>
            </form>
        <?php endif; ?>
        <h3>Daftar Mata Kuliah</h3>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Mata
                        Kuliah</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultAll->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['kodeMK']); ?></td>
                        <td><?php echo htmlspecialchars($row['Matakuliah']); ?></td>
                        <td><?php echo htmlspecialchars($row['SKS']); ?></td>
                        <td class="actions">
                            <a href="matakuliah.php?edit=<?php echo
                                                            urlencode($row['kodeMK']); ?>">Edit</a>
                            <a href="matakuliah.php?delete=<?php echo
                                                            urlencode($row['kodeMK']); ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>