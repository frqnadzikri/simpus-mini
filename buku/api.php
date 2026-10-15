<?php
// Endpoint JSON publik untuk katalog buku (dipakai fetch() di katalog.js).
require __DIR__ . '/../includes/koneksi.php';

header('Content-Type: application/json; charset=utf-8');

$keyword = trim($_GET['q'] ?? '');

try {
    if ($keyword !== '') {
        $stmt = $pdo->prepare("SELECT id, judul, pengarang, tahun, stok FROM buku WHERE judul ILIKE :kw ORDER BY judul LIMIT 50");
        $stmt->execute(['kw' => '%' . $keyword . '%']);
    } else {
        $stmt = $pdo->query("SELECT id, judul, pengarang, tahun, stok FROM buku ORDER BY judul LIMIT 50");
    }
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data']);
}