// Data surat
const suratData = [
    { no: 1, nama: "Andi", jenisSurat: "KTP", tanggal: "2024-11-25", waktu: "08:30", status: "Pending" },
    { no: 2, nama: "Budi", jenisSurat: "Kartu Keluarga", tanggal: "2024-11-27", waktu: "09:45", status: "Selesai" },
    { no: 3, nama: "Citra", jenisSurat: "KTP", tanggal: "2024-11-28", waktu: "10:15", status: "Diproses" },
    { no: 4, nama: "Dewi", jenisSurat: "Surat Pengantar", tanggal: "2024-11-22", waktu: "11:00", status: "Pending" },
    { no: 5, nama: "Eka", jenisSurat: "SKCK", tanggal: "2024-11-20", waktu: "13:30", status: "Selesai" },
    { no: 6, nama: "Fajar", jenisSurat: "Kartu Keluarga", tanggal: "2024-11-23", waktu: "14:00", status: "Diproses" },
    { no: 7, nama: "Gina", jenisSurat: "KTP", tanggal: "2024-11-21", waktu: "15:20", status: "Pending" },
    { no: 8, nama: "Hadi", jenisSurat: "Surat Pengantar", tanggal: "2024-11-26", waktu: "16:00", status: "Diproses" },
    { no: 9, nama: "Ika", jenisSurat: "SKCK", tanggal: "2024-11-19", waktu: "17:10", status: "Selesai" },
    { no: 10, nama: "Joni", jenisSurat: "Kartu Keluarga", tanggal: "2024-11-30", waktu: "18:00", status: "Pending" }
  ];
  
  // Referensi elemen
  const suratList = document.getElementById("surat-list");
  const searchBar = document.getElementById("search-bar");
  const searchBtn = document.getElementById("search-btn");
  
  // Fungsi untuk memuat data surat ke tabel
  function loadSuratTable(data) {
    suratList.innerHTML = ""; // Bersihkan isi tabel sebelumnya
  
    data.forEach((surat) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${surat.no}</td>
        <td>${surat.nama}</td>
        <td>${surat.jenisSurat}</td>
        <td>${surat.tanggal}</td>
        <td>${surat.waktu}</td>
        <td>
          <select onchange="updateStatus(${surat.no}, this.value)">
            <option value="Pending" ${surat.status === "Pending" ? "selected" : ""}>Pending</option>
            <option value="Diproses" ${surat.status === "Diproses" ? "selected" : ""}>Diproses</option>
            <option value="Selesai" ${surat.status === "Selesai" ? "selected" : ""}>Selesai</option>
          </select>
        </td>
        <td><button class="btn-view" onclick="viewDetails(${surat.no})">Lihat</button></td>
      `;
      suratList.appendChild(row);
    });
  }
  
  // Fungsi untuk memperbarui status surat
  function updateStatus(no, newStatus) {
    const surat = suratData.find((item) => item.no === no);
    if (surat) {
      surat.status = newStatus;
      alert(`Status surat dengan nomor ${no} diubah menjadi ${newStatus}.`);
    }
  }
  
  // Fungsi untuk melihat detail surat
  function viewDetails(no) {
    const surat = suratData.find((item) => item.no === no);
    if (surat) {
      alert(`Detail Surat:\nNama: ${surat.nama}\nJenis Surat: ${surat.jenisSurat}\nTanggal: ${surat.tanggal}\nWaktu: ${surat.waktu}\nStatus: ${surat.status}`);
    }
  }
  
  // Fungsi untuk menangani pencarian
  searchBtn.addEventListener("click", () => {
    const searchTerm = searchBar.value.toLowerCase();
  
    // Filter data berdasarkan input pencarian
    const filteredData = suratData.filter((surat) =>
      surat.jenisSurat.toLowerCase().includes(searchTerm) ||
      surat.nama.toLowerCase().includes(searchTerm)
    );
  
    loadSuratTable(filteredData);
  });
  
  // Reset data saat input pencarian dihapus
  searchBar.addEventListener("input", () => {
    if (searchBar.value === "") {
      loadSuratTable(suratData);
    }
  });
  
  // Panggil fungsi untuk memuat data awal
  document.addEventListener("DOMContentLoaded", () => {
    loadSuratTable(suratData);
  });
  
  //LAST, FUNGSI UNTUK LOGOUT
  function confirmLogout() {
    // Tampilkan dialog konfirmasi
    const confirmation = confirm("Yakin ingin keluar?");
    
    // Jika pengguna memilih 'OK' (Ya), arahkan ke halaman login
    if (confirmation) {
        window.location.href = "index.html";
    } 
    // Jika pengguna memilih 'Cancel' (Tidak), tidak lakukan apa-apa
  }