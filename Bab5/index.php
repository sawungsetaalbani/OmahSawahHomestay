<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Omah Sawah Homestay</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Toast CSS */
    #toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 8px;
      padding: 12px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
      font-size: 16px;
      opacity: 0;
      transition: opacity 0.5s, bottom 0.5s;
    }
    #toast.show {
      visibility: visible;
      opacity: 1;
      bottom: 50px;
    }
    .highlight { color: #3b82f6; font-weight: bold; }
  </style>
</head>
<body>
  <h1 id="main-title">Selamat Datang di Omah Sawah Homestay</h1>
  <p id="desc">Nikmati suasana pedesaan yang asri dan tenang di tengah hamparan sawah hijau.</p>

  <h3>Menu Navigasi</h3>
  <ul id="nav-menu">
    <li><a href="login.html">Login</a></li>
    <li><a href="register.html">Register</a></li>
    <li><a href="dashboard.html">Dashboard</a></li>
    <li><a href="about.html">Tentang Kami</a></li>
  </ul>

  <h2>Tentang Omah Sawah Homestay</h2>
  <p id="about">Omah Sawah Homestay menawarkan pengalaman menginap tradisional dengan pemandangan sawah dan udara segar. Cocok untuk wisata keluarga atau liburan santai.</p>

  <h3>Kontak</h3>
  <p>Email: <span id="email">omahsawahhomestay@gmail.com</span></p>
  <p>Telepon: <span id="phone">0812-3456-7890</span></p>

  <!-- Toast -->
  <div id="toast">Ini toast notification!</div>

  <script>

    const title = document.getElementById('main-title');
    title.style.color = '#16a34a';

    const desc = document.getElementById('desc');
    desc.innerHTML = desc.textContent.replace('pedesaan', '<span class="highlight">pedesaan</span>');

    const button = document.createElement('button');
    button.textContent = 'Klik untuk Lihat Toast';
    button.style.padding = '8px 16px';
    button.style.marginTop = '12px';
    button.style.cursor = 'pointer';
    document.body.insertBefore(button, document.getElementById('about'));

    const toast = document.getElementById('toast');
    function showToast(message) {
      toast.textContent = message;
      toast.className = 'show';
      setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
    }
    button.addEventListener('click', () => showToast('Selamat datang di Omah Sawah Homestay!'));

    // PopUp 1: Confirm untuk lihat promo
    const visitBtn = document.createElement('button');
    visitBtn.textContent = 'Konfirmasi Kunjungan';
    visitBtn.style.marginLeft = '12px';
    document.body.insertBefore(visitBtn, button.nextSibling);
    visitBtn.addEventListener('click', () => {
      if (confirm('Apakah kamu ingin melihat promo terbaru dari Omah Sawah Homestay?')) {
        showToast('Promo akan segera ditampilkan!');
        openPromoPopup();
      } else {
        showToast('Oke, maybe next time.');
      }
    });

    // PopUp 2: Custom modal info
    const modalWrap = document.createElement('div');
    modalWrap.innerHTML = `
      <div id="popupBox" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
           background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.3);z-index:1000;">
        <h3>Info Homestay 🌾</h3>
        <p>Nikmati suasana asri dengan pelayanan terbaik kami!</p>
        <button id="closePopup">Tutup</button>
      </div>`;
    document.body.appendChild(modalWrap);
    const popupBox = document.getElementById('popupBox');
    const closePopup = document.getElementById('closePopup');

    const openPopupBtn = document.createElement('button');
    openPopupBtn.textContent = 'Tampilkan Info PopUp';
    openPopupBtn.style.marginLeft = '12px';
    document.body.insertBefore(openPopupBtn, visitBtn.nextSibling);
    openPopupBtn.addEventListener('click', () => popupBox.style.display = 'block');
    closePopup.addEventListener('click', () => popupBox.style.display = 'none');

    // Auto promo popup
    function openPromoPopup() {
      const promo = document.createElement('div');
      promo.innerHTML = `
        <div id="promoBox" style="position:fixed;top:30%;left:50%;transform:translate(-50%,-50%);
             background:#fefce8;border:2px solid #16a34a;padding:25px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.2);z-index:2000;">
          <h3>🎉 Promo November!</h3>
          <p>Menginap 2 malam, gratis 1 malam tambahan.</p>
          <button id="closePromo">Tutup</button>
        </div>`;
      document.body.appendChild(promo);
      promo.querySelector('#closePromo').addEventListener('click', () => promo.remove());
    }
    setTimeout(openPromoPopup, 5000);

    // Events
    title.addEventListener('mouseenter', () => title.style.color = '#22c55e');
    title.addEventListener('mouseleave', () => title.style.color = '#16a34a');
    desc.addEventListener('dblclick', () => alert('Kamu suka suasana pedesaan? 🌾'));
    window.addEventListener('scroll', () => showToast('Kamu sedang scroll halaman!'), { once: true });

    // localStorage usage
    localStorage.setItem('homestay_name', 'Omah Sawah Homestay');
    console.log('Nama homestay di localStorage:', localStorage.getItem('homestay_name'));

    // Async + Fetch + Promise example (dummy API)
    async function getOwner() {
      try {
        const res = await fetch('https://jsonplaceholder.typicode.com/users/1');
        const json = await res.json();
        localStorage.setItem('owner_name', json.name);
        showToast(`Pemilik: ${json.name}`);
      } catch (e) {
        console.error('Fetch gagal:', e);
      }
    }
    // Promise delay simulation
    new Promise(resolve => setTimeout(() => resolve('Selamat datang!'), 800))
      .then(msg => showToast(msg));
    setTimeout(getOwner, 3000);
  </script>
</body>
</html>
