<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah / Edit Kategori</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <div class="card" style="max-width:760px;margin:auto;">
      <h2>Tambah / Edit Kategori</h2>
      <form id="catForm" action="/categories/save" method="post">
        <label>Nama Kategori</label>
        <input type="text" id="catName" name="name" required>

        <label>Deskripsi</label>
        <textarea id="catDesc" name="description" rows="4"></textarea>

        <label>Harga per Malam (IDR)</label>
        <input type="text" id="catPrice" name="price">

        <input type="submit" value="Simpan">
        <a href="categories.html" class="button" style="background:#6b7280; margin-left:8px">Batal</a>
      </form>
    </div>
  </main>

  <script>
    const catForm = document.getElementById('catForm');
    const catName = document.getElementById('catName');
    const catDesc = document.getElementById('catDesc');
    const catPrice = document.getElementById('catPrice');

    // auto save draft to localStorage on input
    [catName, catDesc, catPrice].forEach(el => {
      el.addEventListener('input', () => {
        localStorage.setItem('draftCat', JSON.stringify({
          name: catName.value,
          desc: catDesc.value,
          price: catPrice.value
        }));
      });
    });

    // restore if exists
    window.addEventListener('load', () => {
      const draft = JSON.parse(localStorage.getItem('draftCat') || '{}');
      if (draft && (draft.name || draft.desc || draft.price)) {
        catName.value = draft.name || '';
        catDesc.value = draft.desc || '';
        catPrice.value = draft.price || '';
      }
    });

    // currency format on price input (simple)
    catPrice.addEventListener('input', () => {
      const raw = catPrice.value.replace(/[^\d]/g,'');
      catPrice.value = raw ? raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    });

    // slug preview (simple)
    const slugPreview = document.createElement('div');
    slugPreview.style.marginTop = '8px';
    catForm.appendChild(slugPreview);
    catName.addEventListener('input', () => {
      slugPreview.textContent = 'Slug: ' + catName.value.toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9\-]/g,'');
    });

    // PopUp confirm on submit + simulate save with Promise
    catForm.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!confirm('Simpan perubahan kategori?')) return;
      // simulate async save
      fakeSaveCategory({
        name: catName.value,
        desc: catDesc.value,
        price: catPrice.value
      }).then(res => {
        // success modal
        const s = document.createElement('div');
        s.innerHTML = `<div style="position:fixed;top:40%;left:50%;transform:translate(-50%,-50%);
            background:white;padding:18px;border-radius:8px;box-shadow:0 10px 30px rgba(0,0,0,0.12);z-index:1000;">
            <h3>Sukses</h3><p>Kategori tersimpan (simulasi).</p><button id="okSave">OK</button></div>`;
        document.body.appendChild(s);
        s.querySelector('#okSave').addEventListener('click', () => {
          s.remove();
          localStorage.removeItem('draftCat');
        });
      }).catch(err => {
        alert('Gagal simpan (simulasi).');
      });
    });

    function fakeSaveCategory(payload) {
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          // pseudo: if name kosong => reject
          if (!payload.name) return reject('nama kosong');
          // else resolve
          resolve({ ok: true, data: payload });
        }, 900);
      });
    }
  </script>
</body>
</html>
