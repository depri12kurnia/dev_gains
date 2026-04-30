<div id="page-auth" class="page-section animate-fadeIn py-16 bg-gray-50 flex flex-col justify-center active">
  <div class="max-w-md mx-auto px-4 w-full">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
      <div class="bg-gradient-primary p-8 text-white text-center relative">
        <div
          class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
          <i data-lucide="lock" class="w-8 h-8"></i>
        </div>
        <h1 class="text-2xl font-extrabold mb-1">Portal Login</h1>
        <p class="text-white/90 text-sm">GAINS 2026 Participant Dashboard</p>
      </div>

      <div class="p-8">
        <!-- Messages & Errors from Ion Auth -->
        <?php if (validation_errors()): ?>
          <div class="alert alert-danger mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('message')): ?>
          <div class="alert alert-danger mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            <?php echo $this->session->flashdata('message'); ?>
          </div>
        <?php endif; ?>

        <!-- Login Form -->
        <?php echo form_open("auth/login", ['class' => 'space-y-5']); ?>

        <!-- Email/Username Field (Ion Auth uses 'identity') -->
        <div>
          <label for="identity" class="block text-sm font-medium text-gray-700 mb-1">Email Address or Username</label>
          <?php echo form_input([
            'name' => 'identity',
            'id' => 'identity',
            'type' => 'text',
            'value' => set_value('identity'),
            'class' => 'w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none',
            'placeholder' => 'your@email.com or username',
            'required' => 'required'
          ]); ?>
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <div class="relative">
            <?php echo form_password([
              'name' => 'password',
              'id' => 'password',
              'class' => 'w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none',
              'placeholder' => '••••••••',
              'required' => 'required'
            ]); ?>
            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" id="toggle-password">
              <i class="fas fa-eye-slash" id="eye"></i>
            </button>
          </div>
        </div>

        <!-- Remember Me Checkbox (Ion Auth Feature) -->
        <div class="flex items-center">
          <input type="checkbox" name="remember" id="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" />
          <label for="remember" class="ml-2 text-sm text-gray-700">Remember me for 2 weeks</label>
        </div>

        <!-- Submit Button -->
        <?php echo form_submit([
          'name' => 'submit',
          'id' => 'auth-submit-btn',
          'value' => 'Log In to Dashboard',
          'class' => 'w-full py-3.5 mt-4 rounded-xl text-white font-bold text-lg shadow-md hover:shadow-lg transition-transform hover:-translate-y-0.5 bg-gradient-primary'
        ]); ?>

        <?php echo form_close(); ?>

        <!-- Footer Links -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
          <p class="text-sm text-gray-600 mb-3">
            <span>Don't have an account? </span>
            <a href="<?php echo site_url('auth/register'); ?>"
              class="font-bold text-primary hover:underline">
              Register here
            </a>
          </p>
          <p>
            <a href="<?php echo site_url('auth/forgot_password'); ?>" class="text-sm text-primary hover:underline">
              I forgot my password
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>