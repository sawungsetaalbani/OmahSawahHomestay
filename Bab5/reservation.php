<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Reservasi - Omah Sawah Homestay</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="header">
    <div class="container wrap">
      <div class="brand">Omah Sawah Homestay</div>
      <nav class="nav">
        <a href="dashboard.html">Dashboard</a>
        <a href="categories.html">Kategori</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <h2>Data Reservasi</h2>
      <a class="button" href="reservation-form.html">Buat Reservasi</a>
    </div>

    <div class="card" style="margin-top:12px;">
      <table class="table" id="resTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Tamu</th>
            <th>Kamar</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Ani</td>
            <td>Kamar Deluxe</td>
            <td>2025-11-05</td>
            <td>2025-11-07</td>
            <td>
              <a class="button" href="reservation-form.html">Edit</a>
              <a class="button del-res" href="#" style="background:#b91c1c; margin-left:8px">Hapus</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <script>

    document.querySelectorAll('.del-res').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const tr = e.target.closest('tr');
        if (confirm('Hapus reservasi ini?')) {
          tr.remove();
          showToast('Reservasi dihapus.');
        }
      });
    });

    // small toast util
    function showToast(msg) {
      const t = document.createElement('div');
      t.textContent = msg; t.style = 'position:fixed;left:50%;bottom:20px;transform:translateX(-50%);background:#111;color:#fff;padding:8px 12px;border-radius:6px;z-index:9999';
      document.body.appendChild(t);
      setTimeout(() => t.remove(), 2000);
    }

    // row click -> detail modal
    document.querySelectorAll('#resTable tbody tr').forEach((tr, idx) => {
      tr.addEventListener('click', () => {
        const nama = tr.children[1].textContent;
        const kamar = tr.children[2].textContent;
        const modal = document.createElement('div');
        modal.innerHTML = `<div style="position:fixed;top:30%;left:50%;transform:translate(-50%,-50%);
            background:white;padding:18px;border-radius:8px;box-shadow:0 12px 30px rgba(0,0,0,0.15);z-index:1000;">
            <h3>Detail Reservasi</h3><p>Nama: ${nama}</p><p>Kamar: ${kamar}</p><button id="closeDet">Tutup</button></div>`;
        document.body.appendChild(modal);
        modal.querySelector('#closeDet').addEventListener('click', () => modal.remove());
        // save last viewed
        localStorage.setItem('lastViewedReservation', JSON.stringify({ nama, kamar, time: new Date().toISOString() }));
      });
      // hover highlight
      tr.addEventListener('mouseenter', () => tr.style.background = '#f8f9fa');
      tr.addEventListener('mouseleave', () => tr.style.background = '');
    });

    // search filter (dynamic)
    const search = document.createElement('input');
    search.placeholder = 'Cari nama tamu...';
    search.style.margin = '12px 0';
    document.querySelector('main .container').insertBefore(search, document.querySelector('.card'));
    search.addEventListener('input', () => {
      const q = search.value.toLowerCase();
      document.querySelectorAll('#resTable tbody tr').forEach(tr => {
        const nama = tr.children[1].textContent.toLowerCase();
        tr.style.display = nama.includes(q) ? '' : 'none';
      });
    });

    // fetch availability sample
    async function checkAvailability() {
      try {
        const res = await fetch('https://jsonplaceholder.typicode.com/posts/1');
        const j = await res.json();
        console.log('sample availability:', j);
      } catch (e) { console.error(e); }
    }
    setTimeout(checkAvailability, 2000);
  </script>
</body>
</html>
