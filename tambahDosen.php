<?php
include 'koneksi.php';
$query = "SELECT * FROM dosen";
$result = $conn->query($query);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Variabel untuk menampung pesan alert
$message = "";
$alertClass = "";

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $prodi = $_POST['prodi']; 
    $jabatan = $_POST['jabatan'];

    // Persiapkan query untuk memasukkan data ke database
    $stmt = $conn->prepare("INSERT INTO dosen (nip, nama, alamat, prodi, jabatan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nip, $nama, $alamat, $prodi, $jabatan);

    // Eksekusi query
    if ($stmt->execute()) {
        $message = "Data dosen berhasil ditambahkan!";
        $alertClass = "alert-success";
    } else {
        $message = "Terjadi kesalahan: " . $stmt->error;
        $alertClass = "alert-danger";
    }

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>

<?php
// Memasukkan file header
include 'htmlBuka.php';
?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Tambah Data Dosen</h1>

    <!-- Menampilkan alert jika ada pesan -->
    <?php if ($message): ?>
        <div class="alert <?= $alertClass; ?>" role="alert">
            <?= $message; ?>
        </div>
    <?php endif; ?>

    <form action="tambahDosen.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" id="nip" name="nip" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prodi" class="form-label">Prodi</label>
            <input type="text" id="prodi" name="prodi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Tambah</button>
    </form>
</div>
<?php
// Memasukkan file footer
include 'htmlTutup.php';
?>
