<nav class="navbar">
    <div class="container">
        <div class="nav-inner">
            <a href="<?php echo base_url('home'); ?>" class="nav-brand" style="text-decoration: none; cursor: pointer;">
                <div class="nav-logo-icon">
                    <i data-lucide="shield-plus"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold text-primary" style="line-height: 1;">GAINS 2026</span>
                    <span class="text-xs font-bold text-secondary" style="font-size: 0.65rem; letter-spacing: 0.05em;">POLTEKKES JAKARTA III</span>
                </div>
            </a>
            <div class="nav-toggle" onclick="toggleMenu()">
                ☰
            </div>
            <div class="nav-menu" id="navMenu">
                <a href="<?php echo base_url('home'); ?>" class="nav-link" data-target="home" data-page="home">
                    <i data-lucide="home" style="width: 1rem; height: 1rem;"></i> Home
                </a>

                <a href="<?php echo base_url('about'); ?>" class="nav-link" data-target="about" data-page="about">
                    <i data-lucide="info" style="width: 1rem; height: 1rem;"></i> About GAINS
                </a>

                <div class="dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-target="comp">
                        <i data-lucide="award" style="width: 1rem; height: 1rem;"></i> Competitions <i data-lucide="chevron-down" style="width: 0.8rem; height: 0.8rem;"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php echo base_url('competitions/irpc'); ?>" class="nav-sub-link" data-target="comp-irpc" data-page="irpc">International Pitch (IRPC)</a>
                        <a href="<?php echo base_url('competitions/bppa'); ?>" class="nav-sub-link" data-target="comp-bppa" data-page="bppa">Best Published Paper (BPPA)</a>
                        <a href="<?php echo base_url('competitions/ahic'); ?>" class="nav-sub-link" data-target="comp-ahic" data-page="ahic">Innovation Challenge (AHIC)</a>
                        <a href="<?php echo base_url('competitions/e2ipbc'); ?>" class="nav-sub-link" data-target="comp-e2ipbc" data-page="e2ipbc">Policy Brief (E2I-PBC)</a>
                    </div>
                </div>

                <a href="<?php echo base_url('timeline'); ?>" class="nav-link" data-target="timeline" data-page="timeline">
                    <i data-lucide="calendar" style="width: 1rem; height: 1rem;"></i> Timeline
                </a>

                <a href="<?php echo base_url('reviewers'); ?>" class="nav-link" data-target="reviewers" data-page="reviewers">
                    <i data-lucide="users" style="width: 1rem; height: 1rem;"></i> Reviewers
                </a>

                <div id="nav-user-area"
                    style="margin-left:1rem; display:flex; align-items:center; gap:0.5rem;">

                    <?php if ($this->ion_auth->logged_in()) { ?>

                        <!-- Jika sudah login -->
                        <a href="<?= base_url('dashboard'); ?>"
                            class="btn btn-dark"
                            style="padding:0.5rem 1rem; font-size:14px; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">

                            <i data-lucide="layout-dashboard" style="width:16px; height:16px;"></i>
                            Dashboard
                        </a>

                        <a href="<?= base_url('auth/logout'); ?>"
                            title="Logout"
                            style="padding:0.55rem; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:#666; transition:0.3s;">

                            <i data-lucide="log-out" style="width:18px; height:18px;"></i>
                        </a>

                    <?php } else { ?>

                        <!-- Jika belum login -->
                        <a href="<?= base_url('auth/login'); ?>"
                            class="btn btn-gradient"
                            style="padding:0.5rem 1.5rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">

                            <i data-lucide="log-in" style="width:16px; height:16px;"></i>
                            Portal Login
                        </a>

                    <?php } ?>

                </div>

            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        document.getElementById("navMenu").classList.toggle("show");
    }

    function toggleDropdown(el) {
        el.parentElement.classList.toggle("open");
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const dropdowns = document.querySelectorAll(".dropdown-toggle");

        dropdowns.forEach(function(btn) {

            btn.addEventListener("click", function(e) {

                e.preventDefault();

                let parent = this.closest(".dropdown");

                parent.classList.toggle("open");

            });

        });

    });
</script>