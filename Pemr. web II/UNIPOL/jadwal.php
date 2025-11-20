<?php
// jadwal.php
require 'config.php';

// Fetch dosen & matkul for select
$dosenRes = $mysqli->query("SELECT NIDN, Nama FROM dosen ORDER BY Nama ASC");
$matkulRes = $mysqli->query("SELECT kodeMK, MataKuliah FROM matakuliah ORDER BY MataKuliah ASC");

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nidn = $_POST['NIDN'];
    $kode = $_POST['kodeMK'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];

    $stmt = $mysqli->prepare("INSERT INTO jadwal (NIDN, kodeMK, hari, jam, ruangan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $nidn, $kode, $hari, $jam, $ruangan);
    $stmt->execute();

    header("Location: jadwal.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM jadwal WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    header("Location: jadwal.php");
    exit;
}

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $nidn = $_POST['NIDN'];
    $kode = $_POST['kodeMK'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];

    $stmt = $mysqli->prepare("UPDATE jadwal SET NIDN=?, kodeMK=?, hari=?, jam=?, ruangan=? WHERE id=?");
    $stmt->bind_param('sssssi', $nidn, $kode, $hari, $jam, $ruangan, $id);
    $stmt->execute();

    header("Location: jadwal.php");
    exit;
}

// Prefill edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $mysqli->prepare("SELECT * FROM jadwal WHERE id=?");
    $res->bind_param('i', $id);
    $res->execute();
    $editData = $res->get_result()->fetch_assoc();
}

// Fetch all jadwal with join
$jadwalRes = $mysqli->query("SELECT j.*, d.Nama as NamaDosen, m.MataKuliah FROM jadwal j 
    LEFT JOIN dosen d ON j.NIDN=d.NIDN 
    LEFT JOIN matakuliah m ON j.kodeMK=m.kodeMK 
    ORDER BY FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), jam");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Jadwal Kuliah</h2>
            <nav>
                <a href="index.php">Beranda</a>
                <a href="mahasiswa.php">Mahasiswa</a>
                <a href="dosen.php">Dosen</a>
                <a href="matakuliah.php">Mata Kuliah</a>
            </nav>
        </div>

        <?php if ($editData): ?>
            <h3>Edit Jadwal (ID: <?php echo $editData['id']; ?>)</h3>
            <form method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">

                <div class="form-row">
                    <label>Dosen</label>
                    <select name="NIDN" class="input" required>
                        <?php
                        $dosenRes->data_seek(0);
                        while ($r = $dosenRes->fetch_assoc()) {
                            $sel = ($r['NIDN'] == $editData['NIDN']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($r['NIDN']) . '" ' . $sel . '>' . htmlspecialchars($r['Nama']) . ' (' . $r['NIDN'] . ')</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Mata Kuliah</label>
                    <select name="kodeMK" class="input" required>
                        <?php
                        $matkulRes->data_seek(0);
                        while ($m = $matkulRes->fetch_assoc()) {
                            $sel = ($m['kodeMK'] == $editData['kodeMK']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($m['kodeMK']) . '" ' . $sel . '>' . htmlspecialchars($m['MataKuliah']) . ' (' . $m['kodeMK'] . ')</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-row"><label>Hari</label><input class="input" name="hari" required value="<?php echo htmlspecialchars($editData['hari']); ?>"></div>
                <div class="form-row"><label>Jam</label><input class="input" name="jam" required value="<?php echo htmlspecialchars($editData['jam']); ?>"></div>
                <div class="form-row"><label>Ruangan</label><input class="input" name="ruangan" value="<?php echo htmlspecialchars($editData['ruangan']); ?>"></div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="jadwal.php">Batal</a>
            </form>

        <?php else: ?>
            <h3>Tambah Jadwal</h3>
            <form method="post">
                <input type="hidden" name="action" value="add">

                <div class="form-row">
                    <label>Dosen</label>
                    <select name="NIDN" class="input" required>
                        <option value="">-- Pilih Dosen --</option>
                        <?php $dosenRes->data_seek(0);
                        while ($r = $dosenRes->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($r['NIDN']); ?>"><?php echo htmlspecialchars($r['Nama']); ?> (<?php echo $r['NIDN']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Mata Kuliah</label>
                    <select name="kodeMK" class="input" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php $matkulRes->data_seek(0);
                        while ($m = $matkulRes->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($m['kodeMK']); ?>"><?php echo htmlspecialchars($m['MataKuliah']); ?> (<?php echo $m['kodeMK']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row"><label>Hari</label><input class="input" name="hari" placeholder="Senin" required></div>
                <div class="form-row"><label>Jam</label><input class="input" name="jam" placeholder="08:00-10:00" required></div>
                <div class="form-row"><label>Ruangan</label><input class="input" name="ruangan" placeholder="R/101"></div>

                <button class="btn btn-primary" type="submit">Tambah Jadwal</button>
            </form>
        <?php endif; ?>

        <h3>Daftar Jadwal</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $jadwalRes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['hari']); ?></td>
                        <td><?php echo htmlspecialchars($row['jam']); ?></td>
                        <td><?php echo htmlspecialchars($row['MataKuliah']) . ' (' . $row['kodeMK'] . ')'; ?></td>
                        <td><?php echo htmlspecialchars($row['NamaDosen']) . ' (' . $row['NIDN'] . ')'; ?></td>
                        <td><?php echo htmlspecialchars($row['ruangan']); ?></td>
                        <td class="actions">
                            <a href="jadwal.php?edit=<?php echo $row['id']; ?>">Edit</a>
                            <a href="jadwal.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html> 