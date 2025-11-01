<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Omah Sawah Homestay</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h2>Form Registrasi Pengguna</h2>
  <form id="regForm" action="login.html" method="post">
    <label>Nama Lengkap:</label><br>
    <input type="text" id="fullname" name="fullname" required><br><br>

    <label>Email:</label><br>
    <input type="email" id="regEmail" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" id="regPassword" name="password" required><br><br>

    <label>Konfirmasi Password:</label><br>
    <input type="password" id="regConfirm" name="confirm_password" required><br><br>

    <input type="submit" value="Daftar">
  </form>

  <p>Sudah punya akun? <a href="login.html">Login di sini</a></p>
  <p><a href="index.html">Kembali ke Beranda</a></p>

  <script>

    const regForm = document.getElementById('regForm');

    // Live validation: password match
    const regPwd = document.getElementById('regPassword');
    const regConf = document.getElementById('regConfirm');
    const pwdHint = document.createElement('div');
    pwdHint.style.color = 'red';
    regConf.parentNode.insertBefore(pwdHint, regConf.nextSibling);

    function checkPwdMatch() {
      if (regPwd.value && regConf.value && regPwd.value !== regConf.value) {
        pwdHint.textContent = 'Password tidak cocok';
      } else pwdHint.textContent = '';
    }
    regPwd.addEventListener('input', checkPwdMatch);
    regConf.addEventListener('input', checkPwdMatch);

    // detect capslock on password fields
    [regPwd, regConf].forEach(inp => {
      inp.addEventListener('keydown', (e) => {
        if (e.getModifierState && e.getModifierState('CapsLock')) {
          showTiny('CapsLock aktif');
        }
      });
    });

    // tiny notification
    function showTiny(msg) {
      const t = document.createElement('div');
      t.textContent = msg;
      t.style = 'position:fixed;bottom:20px;left:20px;background:#111;color:#fff;padding:6px 10px;border-radius:6px;z-index:9999';
      document.body.appendChild(t);
      setTimeout(() => t.remove(), 2200);
    }

    // PopUp success modal
    const regModal = document.createElement('div');
    regModal.innerHTML = `
      <div id="regModal" style="display:none;position:fixed;top:40%;left:50%;transform:translate(-50%,-50%);
           background:white;padding:18px;border-radius:8px;box-shadow:0 10px 30px rgba(0,0,0,0.12);z-index:1000;">
        <h3>Registrasi Berhasil</h3>
        <p>Silakan login untuk melanjutkan.</p>
        <button id="closeRegModal">Tutup</button>
      </div>`;
    document.body.appendChild(regModal);
    const regModalBox = document.getElementById('regModal');
    document.getElementById('closeRegModal')?.addEventListener('click', () => regModalBox.style.display = 'none');

    // store partial form in localStorage on input (auto-save)
    ['fullname', 'regEmail'].forEach(id => {
      document.getElementById(id === 'fullname' ? 'fullname' : 'regEmail').addEventListener('input', (e) => {
        localStorage.setItem('reg_' + e.target.id, e.target.value);
      });
    });

    // on load: autofill saved
    window.addEventListener('load', () => {
      const savedName = localStorage.getItem('reg_fullname');
      const savedEmail = localStorage.getItem('reg_regEmail');
      if (savedName) document.getElementById('fullname').value = savedName;
      if (savedEmail) document.getElementById('regEmail').value = savedEmail;
    });

    // fake email availability check (Promise)
    function checkEmailAvail(email) {
      return new Promise((resolve) => {
        setTimeout(() => {
          // pseudo rule: if contains "taken" => not available
          resolve(!email.includes('taken'));
        }, 700);
      });
    }

    regForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const email = document.getElementById('regEmail').value;
      const ok = await checkEmailAvail(email);
      if (!ok) {
        alert('Email sudah terdaftar (simulasi).');
        return;
      }
      regModalBox.style.display = 'block';
      localStorage.setItem('registeredEmail', email);
    });
  </script>
</body>
</html>
