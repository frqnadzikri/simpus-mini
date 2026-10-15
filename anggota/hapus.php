<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/helpers.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

// Pembatasan akses berbasis role: hanya admin yang boleh menghapus anggota.
// Dicek di server (bukan hanya disembunyikan di tampilan) agar tidak bisa
// dilewati dengan mengirim request manual.
if (!is_admin()) {
    http_response_code(403);
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akses ditolak: hanya admin yang boleh menghapus anggota.'];
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.'];
    } catch (PDOException $e) {
        // Anggota yang masih punya riwayat peminjaman tidak boleh dihapus (foreign key).
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak bisa dihapus karena masih memiliki riwayat peminjaman.'];
    }
}

header('Location: list.php');
exit;