<style>
  /* Container Utama */
  .custom-captcha-row {
    display: flex !important;
    align-items: flex-start !important;
    /* Menjaga elemen sejajar dari atas, bukan dari tengah */
  }

  /* Pembungkus Sisi Kiri (Gambar + Tombol) */
  .captcha-left-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    /* Tombol rata kiri di bawah gambar, ubah ke center jika ingin di tengah */
  }

  /* Kotak Gambar Captcha */
  .class-img-captcha {
    width: 100%;
    height: 100%;
    /* Tentukan tinggi pasti gambar captcha */
    border: 1px solid #ced4da;
    border-radius: 6px;
    overflow: hidden;
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .class-img-captcha img {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain;
  }

  /* Tombol Refresh Persis Sesuai Gambar Sketsa Anda */
  .btn-refresh-mini {
    margin-top: 6px;
    height: 32px;
    width: 45px;
    /* Membuat boks tombol lebih kecil dari lebar gambar, mirip sketsa */
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    border: 1px solid #ced4da;
    /* Border tegas hitam/gelap sesuai sketsa */
    border-radius: 6px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-refresh-mini:hover {
    background-color: #f1f3f5;
    border-color: #ced4da;
  }

  /* Kotak Input Sisi Kanan */
  .form-control-custom {
    height: 40px !important;
    /* Tingginya sama persis dengan tinggi .class-img-captcha */
    border: 1px solid #ced4da !important;
    /* Border tegas sesuai sketsa Anda */
    border-radius: 6px !important;
    font-size: 0.95rem;
  }
</style>
<div id="page-auth" class="page-section bg-gray-50 active" style="padding-top:6rem; padding-bottom:6rem;">
  <div class="container" style="max-width: 28rem;">
    <div class="auth-card">
      <div class="auth-header">
        <div style="width:4rem; height:4rem; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
          <i data-lucide="lock" id="auth-icon" style="width:2rem; height:2rem;"></i>
        </div>
        <h1 class="text-2xl mb-1" id="auth-title" style="color:white;">Portal Login</h1>
        <p style="font-size:0.875rem; opacity:0.9;">GAINS 2026 Participant Dashboard</p>
      </div>

      <div class="p-8">
        <!-- Script untuk SweetAlert2 -->
        <script>
          document.addEventListener('DOMContentLoaded', function() {

            // 1. Alert untuk Validation Errors (CodeIgniter)
            <?php if (validation_errors()) : ?>
              Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<?php echo str_replace(["\r", "\n"], '', validation_errors()); ?>',
                confirmButtonColor: '#3085d6',
              });
            <?php endif; ?>

            // 2. Alert untuk Flashdata Message
            <?php if ($this->session->flashdata('message')) : ?>
              Swal.fire({
                icon: 'warning',
                title: 'Attention',
                text: '<?php echo $this->session->flashdata('message'); ?>',
                confirmButtonColor: '#3085d6',
              });
            <?php endif; ?>

            // 3. Tambahan: Alert untuk Flashdata Success (Opsional tapi sering dipakai)
            <?php if ($this->session->flashdata('success')) : ?>
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $this->session->flashdata('success'); ?>',
                timer: 3000,
                showConfirmButton: false
              });
            <?php endif; ?>

          });
        </script>
        <?php echo form_open("auth/login"); ?>
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="identity" required class="form-control" placeholder="jane.doe@university.edu" />
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" required class="form-control" placeholder="••••••••" />
        </div>
        <div class="form-group mb-3">
          <label class="form-label small fw-bold text-dark mb-2">Captcha</label>

          <div class="row g-2 custom-captcha-row">

            <div class="col-5 col-sm-4 captcha-left-wrapper">
              <div class="class-img-captcha" id="captcha-container">
                <?php echo $captcha_image; ?>
              </div>

              <button type="button" id="refresh-captcha" class="btn btn-refresh-mini" title="Refresh Captcha">
                🔄
              </button>
            </div>

            <div class="col-7 col-sm-8">
              <input type="text" name="captcha" id="captcha" required
                class="form-control form-control-custom text-center"
                placeholder="Enter the captcha code">
            </div>

          </div>
        </div>
        <button type="submit" id="auth-submit-btn" class="btn btn-gradient w-full mt-4 text-lg">
          Log In to Dashboard
        </button>
        <?php echo form_close(); ?>
        <div style="margin-top: 15px; text-align: center;">
          <p class="text-sm text-gray-600">Or Login Using Google:</p>
          <a href="<?php echo $google_login_url; ?>">
            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Google Sign In" style="width: 200px;">
          </a>
        </div>
        <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--gray-100); text-align:center;">
          <p class="text-sm text-gray-600">
            <span id="auth-switch-text">Don't have an account? </span>
            <a href="<?php echo site_url('auth/register'); ?>" class="font-bold text-primary" style="text-decoration:underline;">
              Register here
            </a>
          </p>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#refresh-captcha').on('click', function(e) {
      e.preventDefault();

      // Buat string acak unik berbasis waktu milidetik saat ini
      var antiCache = new Date().getTime();

      $.ajax({
        type: 'GET',
        // Paksa URL memiliki parameter unik di belakangnya (?_=123456789)
        url: '<?php echo base_url("auth/refresh_captcha"); ?>?_=' + antiCache,
        cache: false, // Menolak cache bawaan jQuery
        success: function(html) {
          // Hapus isi boks lama, lalu masukkan gambar yang baru
          $('#captcha-container').html(html);

          // Reset kolom input teks agar user tahu captcha sudah berganti
          $('#captcha').val('');
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: " + error);
          alert('Gagal mengambil gambar captcha baru.');
        }
      });
    });
  });
</script>