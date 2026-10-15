// Jobsheet 6: fetch + JSON, loading indicator, penanganan error, async/await.
// Sekarang memanggil endpoint PHP sungguhan (buku/api.php), bukan file JSON statis.
(function () {
    const tabel = document.getElementById("katalog-tabel");
    const status = document.getElementById("katalog-status");
    const cari = document.getElementById("katalog-cari");
    if (!tabel || !status) return;

    const tbody = tabel.querySelector("tbody");
    const api = tabel.dataset.api;

    function tampilStatus(teks, error) {
        status.hidden = false;
        status.textContent = teks;
        status.className = error ? "flash flash-error" : "loading";
    }

    function sembunyiStatus() {
        status.hidden = true;
    }

    function render(daftar) {
        tbody.textContent = "";
        if (daftar.length === 0) {
            const tr = document.createElement("tr");
            const td = document.createElement("td");
            td.colSpan = 4;
            td.textContent = "Tidak ada buku yang cocok.";
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }
        daftar.forEach(function (b) {
            const tr = document.createElement("tr");
            [b.judul, b.pengarang, b.tahun, b.stok].forEach(function (nilai) {
                const td = document.createElement("td");
                td.textContent = nilai; // textContent: aman dari XSS
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });
    }

    async function muatData(keyword) {
        tampilStatus("Memuat data...", false);
        try {
            const res = await fetch(api + "?q=" + encodeURIComponent(keyword || ""));
            if (!res.ok) throw new Error("HTTP " + res.status);
            const data = await res.json();
            render(data);
            sembunyiStatus();
        } catch (err) {
            tbody.textContent = "";
            tampilStatus("Gagal memuat data. Coba lagi nanti.", true);
        }
    }

    let timer;
    if (cari) {
        cari.addEventListener("input", function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                muatData(cari.value.trim());
            }, 300);
        });
    }

    muatData("");
})();