const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');

function toggleSidebar() {
  // Toggle status sidebar (buka/tutup)
  sidebar.classList.toggle('close');
  toggleButton.classList.toggle('rotate');

  // Tutup semua submenu hanya jika sidebar ditutup
  if (sidebar.classList.contains('close')) {
    closeAllSubMenus();
  }
}

function toggleSubMenu(button) {
  // Toggle submenu terkait
  const subMenu = button.nextElementSibling; // Ambil elemen .sub-menu

  if (subMenu) {
    subMenu.classList.toggle('show'); // Tampilkan/sembunyikan submenu
    button.classList.toggle('rotate'); // Ubah ikon toggle
  }

  // Sidebar tetap terbuka meskipun submenu ditekan
  if (sidebar.classList.contains('close')) {
    sidebar.classList.remove('close');
    toggleButton.classList.remove('rotate');
  }
}

function closeAllSubMenus() {
  // Tutup semua submenu dan reset rotasi tombol
  Array.from(sidebar.getElementsByClassName('show')).forEach((ul) => {
    ul.classList.remove('show'); // Hilangkan kelas 'show'
    ul.previousElementSibling.classList.remove('rotate'); // Reset ikon toggle
  });
}
