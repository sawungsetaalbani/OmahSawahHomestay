// ==== POPUP BOX 1 ====
// Welcome popup saat buka index.html
window.addEventListener('load', () => {
    alert("Selamat datang di Omah Sawah Homestay! 🌾");
});

// ==== FETCH + ASYNC + PROMISE ====
// Ambil info homestay dari JSON dummy
async function loadHomestayInfo() {
    try {
        let response = await fetch('data/homestay.json'); // buat file JSON di folder data
        if (!response.ok) throw new Error('Gagal load data');
        let data = await response.json();
        document.getElementById('homestay-info').textContent = data.info;
    } catch(err) {
        console.error(err);
        document.getElementById('homestay-info').textContent = "Info tidak tersedia.";
    }
}
if(document.getElementById('homestay-info')) loadHomestayInfo();

// ==== EVENT 1 ====
// Hover link login
document.getElementById('login-link')?.addEventListener('mouseover', () => {
    console.log("Hover di link Login!");
});

// ==== EVENT 2 ====
// Fokus input email
document.getElementById('email')?.addEventListener('focus', () => {
    console.log("Input email dipilih!");
});

// ==== EVENT 3 + POPUP BOX 2 ====
// Form submit login
document.getElementById('login-form')?.addEventListener('submit', function(e){
    e.preventDefault();
    const email = document.getElementById('email').value;
    localStorage.setItem('userEmail', email); // Web Storage
    alert(`Login sukses! Selamat datang, ${email}`);
    window.location.href = 'dashboard.html';
});
