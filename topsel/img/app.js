// Fungsi untuk toggle dropdown menu
function toggleDropdown() {
    document.querySelector('.dropdown').classList.toggle('active');
  }
  
  // Menambahkan event listener untuk mengaktifkan dropdown saat diklik
  document.querySelector('.dropbtn').addEventListener('click', toggleDropdown);
  
  // Fungsi untuk 'Edit' action
  function edit() {
    alert("Edit option clicked!");
  }
  
  // Fungsi untuk 'Delete' action
  function deleteItem() {
    alert("Delete option clicked!");
  }
  