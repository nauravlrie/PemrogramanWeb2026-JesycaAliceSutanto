//konfirmasi hapus data
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        // Mengambil nama pada kolom kedua tabel untuk pesan konfirmasi
        const row = form.closest("tr");
        const nama = row ? (row.querySelectorAll("td")[1]?.textContent.trim() || "data ini") : "data ini";

        const yakin = confirm("Apakah Anda yakin ingin menghapus \"" + nama + "\"? Data yang dihapus tidak dapat dikembalikan.");
        if (!yakin) {
            e.preventDefault(); //Membatalkan pengiriman formulir
        }
    });
}

// pencarian realtime
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            // Mengabaikan baris kosong 
            if (row.querySelector("td[colspan]")) return;

            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// Menjalankan fungsi 
document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initTableFilter();
});