<?php
$page_title = "Katalog Buku (AJAX)";
include __DIR__ . '/../includes/header.php';
$extra_scripts = [$base . 'assets/js/katalog.js'];
?>
        <section>
            <h2>Katalog Buku (AJAX)</h2>
            <p>Data dimuat tanpa reload halaman memakai <code>fetch()</code> dari endpoint JSON <code>buku/api.php</code>.</p>

            <div class="search-box">
                <span>
                    <label for="katalog-cari">Cari Judul Buku</label><br>
                    <input type="text" id="katalog-cari" placeholder="Ketik judul buku..." autocomplete="off">
                </span>
            </div>

            <p id="katalog-status" class="loading" hidden></p>

            <div class="table-responsive">
            <table id="katalog-tabel" data-api="api.php">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>