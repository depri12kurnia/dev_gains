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

        <button type="submit" id="auth-submit-btn" class="btn btn-gradient w-full mt-4 text-lg">
          Log In to Dashboard
        </button>
        <?php echo form_close(); ?>

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