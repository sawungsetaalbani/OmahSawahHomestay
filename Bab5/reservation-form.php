<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat / Edit Reservasi</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <div class="card" style="max-width:760px;margin:auto;">
      <h2>Buat / Edit Reservasi</h2>
      <form action="reservation-proses.php" method="post" enctype="multipart/form-data">
        <label>Nama Pemesan</label>
        <input type="text" id="guest_name" name="guest_name" required>

        <label>Pilih Kategori / Kamar</label>
        <select id="category" name="category">
          <option value="standard">Kamar Standard</option>
          <option value="deluxe">Kamar Deluxe</option>
          <option value="family">Family Room</option>
        </select>

        <label>Check-in</label>
        <input type="date" id="checkin" name="checkin">

        <label>Check-out</label>
        <input type="date" id="checkout" name="checkout">

        <input type="submit" value="Simpan Reservasi">
        <a href="reservations.html" class="button" style="background:#6b7280; margin-left:8px">Batal</a>
      </form>
    </div>
  </main>

  <script>

    const resForm = document.getElementById('resForm');
    const guestName = document.getElementById('guest_name');
    const cat = document.getElementById('category');
    const checkin = document.getElementById('checkin');
    const checkout = document.getElementById('checkout');

    // nights preview
    const nightsPreview = document.createElement('div');
    nightsPreview.style.marginTop = '8px';
    resForm.insertBefore(nightsPreview, resForm.querySelector('input[type="submit"]'));

    function calcNights() {
      if (!checkin.value || !checkout.value) { nightsPreview.textContent = ''; return; }
      const a = new Date(checkin.value);
      const b = new Date(checkout.value);
      const ms = b - a;
      const nights = Math.max(0, Math.ceil(ms / (1000*60*60*24)));
      nightsPreview.textContent = `Jumlah malam: ${nights}`;
    }
    checkin.addEventListener('change', calcNights);
    checkout.addEventListener('change', calcNights);

    // availability simulation (promise)
    function checkRoomAvailability(category) {
      return new Promise((resolve) => {
        setTimeout(() => {
          // pseudo rule: family room sometimes full
          resolve(category !== 'family');
        }, 700);
      });
    }

    resForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!confirm('Konfirmasi simpan reservasi?')) return;
      const catVal = cat.value;
      const ok = await checkRoomAvailability(catVal);
      if (!ok) {
        alert('Kamar tidak tersedia untuk tanggal ini (simulasi).');
        return;
      }
      // summary modal
      const modal = document.createElement('div');
      modal.innerHTML = `<div style="position:fixed;top:30%;left:50%;transform:translate(-50%,-50%);
            background:white;padding:18px;border-radius:8px;box-shadow:0 10px 30px rgba(0,0,0,0.12);z-index:1000;">
            <h3>Reservasi Tersimpan</h3><p>Nama: ${guestName.value}</p><p>Kamar: ${catVal}</p>
            <button id="closeResModal">OK</button></div>`;
      document.body.appendChild(modal);
      modal.querySelector('#closeResModal').addEventListener('click', () => modal.remove());

      // save last reservation to localStorage
      localStorage.setItem('lastReservation', JSON.stringify({
        guest: guestName.value,
        category: catVal,
        checkin: checkin.value,
        checkout: checkout.value,
        timestamp: new Date().toISOString()
      }));
    });

    // event: change category -> show estimated price (simple)
    const priceHint = document.createElement('div'); priceHint.style.marginTop = '6px';
    resForm.insertBefore(priceHint, nightsPreview);
    cat.addEventListener('change', () => {
      const map = { standard: 'Rp 300.000', deluxe: 'Rp 450.000', family: 'Rp 700.000' };
      priceHint.textContent = `Estimasi harga per malam: ${map[cat.value] || '-'}`;
    });

    // on load: restore last reservation to fields (if any)
    window.addEventListener('load', () => {
      const last = JSON.parse(localStorage.getItem('lastReservation') || 'null');
      if (last) {
        guestName.value = last.guest || '';
        cat.value = last.category || 'standard';
        checkin.value = last.checkin || '';
        checkout.value = last.checkout || '';
        calcNights();
      }
    });
  </script>
</body>
<script>
  // Popup konfirmasi sebelum submit
  const form = document.querySelector('form');
  form.addEventListener('submit', (e) => {
    if (!confirm('Yakin data reservasi sudah benar?')) {
      e.preventDefault();
    }
  });

  // Simpen nama user ke localStorage
  localStorage.setItem('username', 'Sawung');
  console.log('User:', localStorage.getItem('username'));
</script>

</html>
