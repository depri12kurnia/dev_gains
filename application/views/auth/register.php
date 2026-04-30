<div id="page-auth" class="page-section bg-gray-50 active" style="padding-top:6rem; padding-bottom:6rem;">
    <div class="container" style="max-width: 28rem;">
        <div class="auth-card">
            <div class="auth-header">
                <div style="width:4rem; height:4rem; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                    <i data-lucide="notebook-pen" id="auth-icon" style="width:2rem; height:2rem;"></i>
                </div>
                <h1 class="text-2xl mb-1" id="auth-title" style="color:white;">Portal Registration</h1>
                <p style="font-size:0.875rem; opacity:0.9;">GAINS 2026 Participant Dashboard</p>
            </div>

            <div class="p-8">
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('message')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php endif; ?>
                <?php echo form_open("auth/register_process"); ?>
                <input type="hidden" name="csrf_token_jkt3" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>Email :</label>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password :</label>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-eye-slash" id="eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Retype Password :</label>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Retype password" name="password_confirm" required id="password_confirm">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-eye-slash" id="eye2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Full Name :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Full Name" name="first_name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Phone Number :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Phone Number" name="phone" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" id="auth-submit-btn" class="btn btn-gradient w-full mt-4 text-lg">
                    Register
                </button>
                <?php echo form_close(); ?>

                <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--gray-100); text-align:center;">
                    <p class="text-sm text-gray-600">
                        <span id="auth-switch-text">I already have a account? </span>
                        <a href="<?php echo site_url('auth/login'); ?>" class="font-bold text-primary" style="text-decoration:underline;">
                            Login here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>