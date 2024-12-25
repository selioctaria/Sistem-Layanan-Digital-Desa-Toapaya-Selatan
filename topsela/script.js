// Fungsi menampilkan tab
function showTab(tabId) {
  const tabs = document.querySelectorAll(".tab");
  tabs.forEach((tab) => tab.classList.remove("active"));
  document.getElementById(tabId).classList.add("active");
}

// validasi login
function validateLogin() {
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  let valid = true;

  // error
  document.getElementById("email-error").style.display = "none";
  document.getElementById("password-error").style.display = "none";

  // validasi email
  if (!email.value) {
    document.getElementById("email-error").style.display = "block";
    document.getElementById("email-error").innerText = "Email is required";
    valid = false;
  }

  // validasi password
  if (!password.value) {
    document.getElementById("password-error").style.display = "block";
    document.getElementById("password-error").innerText =
      "Password is required";
    valid = false;
  }

  if (valid) {
    alert("Login Successful");
    window.location.href = "dashboard/index.html";
  }
}

// membuka complaint tab
function openComplaint() {
  const complaintPopup = document.getElementById("complaint");
  complaintPopup.classList.add("active");
}

// mengirim keluhan
function sendComplaint() {
  const complaintText = document.getElementById("complaint-text").value;

  // pop up
  if (complaintText) {
    document.getElementById("complaint").classList.remove("active");

    const successPopup = document.getElementById("complaint-success");
    successPopup.classList.add("active");
  } else {
    alert("Please write your complaint before submitting.");
  }
}

// menutup pop up
function closePopup() {
  document.getElementById("complaint").classList.remove("active");
}

// go to home jika sukses
function goToHomePage() {
  document.getElementById("complaint-success").classList.remove("active");
  showTab("home");
}

// menampilkan reset password tab
function showForgotPassword() {
  showTab("forgot-password");
}

// mengirim reset link
function sendResetLink() {
  const resetEmail = document.getElementById("reset-email").value;
  if (resetEmail) {
    alert("Reset link sent to your email.");
    showTab("login");
  } else {
    alert("Please enter your email to reset password.");
  }
}
