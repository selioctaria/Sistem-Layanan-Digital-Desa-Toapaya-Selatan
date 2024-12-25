// Menangkap elemen-elemen form
// Simulasi data pengguna (biasanya ini akan datang dari server, API, atau database)
const userData = {
  name: "Alvira Angraini",
  email: "Alviraangraini549@gmail.com",
  phone: "083183517525",
  idNumber: "987654321",
  status: "aktif",
  gender: "famale",
  address: "Jl. Raya No. 123, Tanjung Pinang"
};

// Fungsi untuk mengisi data profil ke dalam form
function populateProfile() {
  document.getElementById("name").value = userData.name;
  document.getElementById("email").value = userData.email;
  document.getElementById("phone").value = userData.phone;
  document.getElementById("id-number").value = userData.idNumber;
  document.getElementById("address").value = userData.address;
  
  // Set status
  const statusSelect = document.getElementById("status");
  for (let i = 0; i < statusSelect.options.length; i++) {
    if (statusSelect.options[i].value === userData.status) {
      statusSelect.selectedIndex = i;
      break;
    }
  }
  
  // Set gender
  const genderSelect = document.getElementById("gender");
  for (let i = 0; i < genderSelect.options.length; i++) {
    if (genderSelect.options[i].value === userData.gender) {
      genderSelect.selectedIndex = i;
      break;
    }
  }
}

// Fungsi untuk menangani simpan perubahan (contoh sederhana)
function saveProfile() {
  const updatedUserData = {
    name: document.getElementById("name").value,
    email: document.getElementById("email").value,
    phone: document.getElementById("phone").value,
    idNumber: document.getElementById("id-number").value,
    status: document.getElementById("status").value,
    gender: document.getElementById("gender").value,
    address: document.getElementById("address").value,
  };

  // Simulasi penyimpanan data (misalnya kirim ke server atau API)
  console.log("Data Profil Disimpan:", updatedUserData);

  // Menampilkan notifikasi bahwa data berhasil disimpan
  alert("Perubahan Profil Berhasil Disimpan!");
}

// Event listener untuk tombol simpan
document.getElementById("save-profile").addEventListener("click", saveProfile);

// Panggil fungsi populateProfile saat halaman dimuat
window.onload = populateProfile;



//LAST, FUNGSI UNTUK LOGOUT
function confirm1Logout() {
  // Tampilkan dialog konfirmasi
  const confirmation = confirm("Yakin ingin keluar?");
  
  // Jika pengguna memilih 'OK' (Ya), arahkan ke halaman login
  if (confirmation) {
      window.location.href = "index.html";
  } 
  // Jika pengguna memilih 'Cancel' (Tidak), tidak lakukan apa-apa
}