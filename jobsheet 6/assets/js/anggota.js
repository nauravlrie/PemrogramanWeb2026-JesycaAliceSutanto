// assets/js/anggota.js

// Fungsi asinkron untuk mengambil data anggota dari anggota.json
async function muatDataAnggota() {
    const loadingIndicator = document.getElementById("loading-indicator");
    const tbody = document.getElementById("tabel-anggota-body");

    try {
        // Tampilkan indikator loading
        if (loadingIndicator) loadingIndicator.style.display = "block";

        // Simulasi network delay 600ms agar efek loading terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        // Mengambil berkas JSON dari folder data
        const response = await fetch("../data/anggota.json");

        if (!response.ok) {
            throw new Error(`Gagal memuat data (Status: ${response.status})`);
        }

        const dataAnggota = await response.json();

        // Bersihkan isi tabel sebelum diisi data baru
        tbody.innerHTML = "";

        // Render setiap baris anggota ke dalam tabel
        dataAnggota.forEach((anggota) => {
            const tr = document.createElement("tr");

            tr.innerHTML = `
                <td>${anggota.no_anggota}</td>
                <td>${anggota.nama}</td>
                <td>${anggota.alamat}</td>
                <td>${anggota.no_hp}</td>
                <td>
                    <button class="btn-sm btn-edit" onclick="alert('Edit anggota: ${anggota.nama}')">Edit</button>
                    <button class="btn-sm btn-hapus" data-nama="${anggota.nama}">Hapus</button>
                </td>
            `;

            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error("Terjadi kesalahan:", error);
        if (loadingIndicator) {
            loadingIndicator.textContent = "Gagal memuat data anggota: " + error.message;
            loadingIndicator.style.color = "red";
            return;
        }
    } finally {
        // Sembunyikan indikator loading setelah selesai
        if (loadingIndicator && !loadingIndicator.textContent.includes("Gagal")) {
            loadingIndicator.style.display = "none";
        }
    }
}

// Jalankan fungsi setelah seluruh dokumen HTML siap
document.addEventListener("DOMContentLoaded", function () {
    muatDataAnggota();
});