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

            <div class="nav-menu desktop-only">
                <a href="<?php echo base_url('home'); ?>" class="nav-link" data-target="home" data-page="home">
                    <i data-lucide="home" style="width: 1rem; height: 1rem;"></i> Home
                </a>

                <a href="<?php echo base_url('about'); ?>" class="nav-link" data-target="about" data-page="about">
                    <i data-lucide="info" style="width: 1rem; height: 1rem;"></i> About GAINS
                </a>

                <div class="dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-target="comp">
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

                <div id="nav-auth-buttons" style="margin-left: 1rem;">
                    <a href="<?php echo base_url('auth'); ?>" class="btn btn-gradient" style="padding: 0.5rem 1.5rem; text-decoration: none; display: inline-block;" data-page="auth">
                        Portal Login
                    </a>
                </div>

                <div id="nav-user-buttons" class="hidden items-center" style="margin-left: 1rem; gap: 0.5rem;">
                    <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-dark" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center;" data-page="dashboard">
                        <i data-lucide="layout-dashboard" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i> Dashboard
                    </a>
                    <a href="javascript:void(0)" onclick="handleLogout()" style="padding: 0.5rem; color: var(--gray-500); border-radius: 50%; display: inline-flex;" title="Logout" onmouseover="this.style.color='var(--danger)'; this.style.backgroundColor='var(--danger-light)'" onmouseout="this.style.color='var(--gray-500)'; this.style.backgroundColor='transparent'">
                        <i data-lucide="log-out" style="width: 1.25rem; height: 1.25rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>