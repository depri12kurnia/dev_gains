<?php if ($this->ion_auth->in_group('participant')) {  ?>
    <!-- Registration Status -->
    <?php
    $status = $user_status; // ambil dari database

    $progress = 0;

    switch ($status) {
        case 'registered':
            $progress = 20;
            break;
        case 'pending':
            $progress = 30;
            break;
        case 'rejected':
            $progress = 30; // tetap di sini
            break;
        case 'approved':
            $progress = 60;
            break;
        case 'submitted':
            $progress = 100;
            break;
    }
    ?>
    <!-- End registration status -->
    <!-- payment status -->
    <?php
    $status_payment = $user_status; // ambil dari database

    $progress_payment = 0;

    switch ($status_payment) {
        case 'registered':
            $progress_payment = 20;
            break;
        case 'pending':
            $progress_payment = 60;
            break;
        case 'rejected':
            $progress_payment = 60; // tetap di sini
            break;
        case 'approved':
            $progress_payment = 100;
            break;
    }
    ?>
    <!-- end payment status -->
    <!-- submission status -->
    <?php
    $status_submission = $submission_status; // ambil dari database

    $progress_submission = 0;

    switch ($status_submission) {
        case 'registered':
            $progress_submission = 20;
            break;
        case 'submitted':
            $progress_submission = 60;
            break;
        case 'not selected':
            $progress_submission = 60; // tetap di sini
            break;
        case 'finalist':
            $progress_submission = 100;
            break;
    }
    ?>
    <!-- end submission status -->
    <div class="dash-sidebar">
        <!-- Participant -->
        <div class="flex items-center mb-8" style="gap:0.75rem;">

            <div>
                <h3 style="font-size:0.7rem; margin:0;"><?= $user['email']; ?></h3>
                <span class="text-gray-500" style="font-size:0.75rem;">Participant</span>
            </div>
        </div>

        <nav>
            <button onclick="switchDashboardTab('dashboard')" id="tab-btn-dashboard" class="dash-tab-btn active">
                <i data-lucide="layout-dashboard" style="width:1.25rem;"></i> Dashboard
            </button>
            <button onclick="switchDashboardTab('payment')" id="tab-btn-payment" class="dash-tab-btn">
                <i data-lucide="credit-card" style="width:1.25rem;"></i> Payment Info
            </button>
            <?php if ($status_payment == 'approved'): ?>
                <button onclick="switchDashboardTab('submission')" id="tab-btn-submission" class="dash-tab-btn">
                    <i data-lucide="upload" style="width:1.25rem;"></i> My Submission
                </button>
            <?php endif; ?>
            <button onclick="switchDashboardTab('settings')" id="tab-btn-settings" class="dash-tab-btn">
                <i data-lucide="settings" style="width:1.25rem;"></i> Settings
            </button>
        </nav>
    </div>

    <div class="dash-main">
        <!-- Tab: Dashboard -->
        <div id="dash-tab-dashboard" class="dash-content active">
            <h2 class="text-2xl mb-2">Welcome to your Portal!</h2>
            <p class="text-gray-600 mb-8">Manage your registration, complete your payment, and submit your documents here.</p>
            <!-- End Registration Status -->
            <!-- Payment and Submission Status  -->
            <div class="grid md-grid-2">
                <!-- Payment Status -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg">Payment Status</h3>

                        <span style="padding:0.25rem 0.75rem; background:var(--warning-bg); color:var(--warning-text); font-size:0.75rem; font-weight:bold; border-radius:9999px; text-transform:uppercase;"><?php
                                                                                                                                                                                                                $status = strtolower($user_status);

                                                                                                                                                                                                                $map = [
                                                                                                                                                                                                                    'registered' => 'Registered',
                                                                                                                                                                                                                    'pending'    => 'Pending',
                                                                                                                                                                                                                    'approved'   => 'Approved',
                                                                                                                                                                                                                    'rejected'   => 'Rejected',
                                                                                                                                                                                                                    'submitted'  => 'Submitted & Under Review',
                                                                                                                                                                                                                    'not selected' => 'Not Selected',
                                                                                                                                                                                                                    'finalist'   => 'Finalist',
                                                                                                                                                                                                                ];

                                                                                                                                                                                                                echo $map[$status] ?? 'Unknown';
                                                                                                                                                                                                                ?></span>
                    </div>
                    <div style="position:relative; padding-top:0.5rem;">
                        <div style="overflow:hidden; height:0.5rem; margin-bottom:1rem; display:flex; border-radius:0.25rem; background:var(--gray-100);">
                            <div style="width:<?= $progress_payment ?>%; background:var(--primary);"></div>
                        </div>
                        <div class="flex justify-between" style="font-size:0.75rem; font-weight:500;">

                            <span class="<?= $status == 'registered' ? 'text-primary font-bold' : 'text-gray-400' ?>">Registered</span>

                            <span class="<?= $status == 'pending' ? 'text-primary font-bold' : 'text-gray-400' ?>">Payment <br><?php if ($status == 'rejected'): ?>
                                    <div class="alert alert-danger mt-2">
                                        Your payment was rejected, please re-upload your proof of payment.
                                    </div>
                                <?php endif; ?>
                            </span>

                            <span class="<?= $status == 'approved' ? 'text-primary font-bold' : 'text-gray-400' ?>">Approved</span>

                        </div>
                    </div>
                    <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                        <?php
                        $status = strtolower(trim((string)$user_status));

                        $map = [
                            'registered' => [
                                'text'  => 'You haven\'t completed your registration fee payment. Please proceed to the Payment Info & Upload tab to upload your proof of transfer and secure your spot',
                                'color' => '#6c757d',
                                'icon'  => 'user-plus'
                            ],
                            'pending' => [
                                'text'  => 'You haven\'t completed your registration fee payment. Please proceed to the Payment Info & Upload tab to upload your proof of transfer and secure your spot. ',
                                'color' => '#ffc107',
                                'icon'  => 'clock'
                            ],
                            'approved' => [
                                'text'  => 'Your payment has been verified! However, you haven\'t selected a competition category or submitted your files yet. Please proceed to the My Submission tab to complete your application before the deadline (June 2026).',
                                'color' => '#28a745',
                                'icon'  => 'check-circle'
                            ],
                            'rejected' => [
                                'text'  => 'Rejected',
                                'color' => '#dc3545',
                                'icon'  => 'x-circle'
                            ],

                        ];

                        $data = $map[$status] ?? [
                            'text'  => 'Unknown',
                            'color' => '#999',
                            'icon'  => 'help-circle'
                        ];
                        ?>

                        <!-- ICON -->
                        <i data-lucide="<?= $data['icon']; ?>"
                            style="color:<?= $data['color']; ?>; margin-right:0.75rem; flex-shrink:0;">
                        </i>

                        <div>
                            <h4 style="font-size:0.875rem; color:<?= $data['color']; ?>; margin-bottom:0.25rem;">
                                <?= $data['text']; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- end: Payment Status -->
                <!-- Submission Status -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg">Submission Status</h3>

                        <span style="padding:0.25rem 0.75rem; background:var(--warning-bg); color:var(--warning-text); font-size:0.75rem; font-weight:bold; border-radius:9999px; text-transform:uppercase;"><?php
                                                                                                                                                                                                                $status = strtolower($submission_status);

                                                                                                                                                                                                                $map = [
                                                                                                                                                                                                                    'registered' => 'Registered',
                                                                                                                                                                                                                    'submitted'  => 'Submitted & Under Review',
                                                                                                                                                                                                                    'not selected' => 'Not Selected',
                                                                                                                                                                                                                    'finalist'   => 'Finalist',
                                                                                                                                                                                                                ];

                                                                                                                                                                                                                echo $map[$status] ?? 'Unknown';
                                                                                                                                                                                                                ?></span>
                    </div>
                    <div style="position:relative; padding-top:0.5rem;">
                        <div style="overflow:hidden; height:0.5rem; margin-bottom:1rem; display:flex; border-radius:0.25rem; background:var(--gray-100);">
                            <div style="width:<?= $progress_submission ?>%; background:var(--primary);"></div>
                        </div>
                        <div class="flex justify-between" style="font-size:0.75rem; font-weight:500;">

                            <span class="<?= $submission_status == 'registered' ? 'text-primary font-bold' : 'text-gray-400' ?>">Registered</span>

                            <span class="<?= $submission_status == 'submitted' ? 'text-primary font-bold' : 'text-gray-400' ?>">Submitted & Under Review <br> <?php if ($submission_status == 'not selected'): ?>
                                    <div class="alert alert-danger mt-2">
                                        Your submission was not selected.
                                    </div>
                                <?php endif; ?>
                            </span>

                            <span class="<?= $submission_status == 'finalist' ? 'text-primary font-bold' : 'text-gray-400' ?>">Finalist</span>

                        </div>
                    </div>
                    <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                        <?php
                        $status = strtolower(trim((string)$submission_status));

                        $map = [
                            'registered' => [
                                'text'  => 'Please wait for your payment to be approved first, my submission menu will appear.',
                                'color' => '#6c757d',
                                'icon'  => 'user-plus'
                            ],
                            'submitted' => [
                                'text'  => 'Your submission has been successfully received and is currently under review by our expert panel. Please wait for the Acceptance Notification in August 2026.',
                                'color' => '#17a2b8',
                                'icon'  => 'search'
                            ],
                            'not selected' => [
                                'text'  => 'Thank you for your valuable participation in GAINS 2026. Unfortunately, your submission was not selected for the final round this year. We highly appreciate your effort and encourage you to join us again next year.',
                                'color' => '#fa0808',
                                'icon'  => 'timer-off'
                            ],
                            'finalist' => [
                                'text'  => 'Congratulations! You have been shortlisted for the final round! Please check your email for presentation guidelines and confirm your physical/online attendance for the Conference & Final GAINS on 15-16 September 2026.',
                                'color' => '#CFB53B',
                                'icon'  => 'award'
                            ],
                        ];

                        $data = $map[$status] ?? [
                            'text'  => 'Unknown',
                            'color' => '#999',
                            'icon'  => 'help-circle'
                        ];
                        ?>

                        <!-- ICON -->
                        <i data-lucide="<?= $data['icon']; ?>"
                            style="color:<?= $data['color']; ?>; margin-right:0.75rem; flex-shrink:0;">
                        </i>

                        <div>
                            <h4 style="font-size:0.875rem; color:<?= $data['color']; ?>; margin-bottom:0.25rem;">
                                <?= $data['text']; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- End Submission Status -->
            </div>
            <!-- End Payment and Submission Status -->
            </br>
            <div class="grid md-grid-2">
                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <h3 class="text-lg mb-4" style="border-bottom:1px solid var(--gray-200); padding-bottom:0.5rem;">Profile Information</h3>
                    <ul style="display:flex; flex-direction:column; gap:0.75rem; font-size:0.875rem;">
                        <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Full Name</span> <span class="font-bold"><?= $user['name']; ?></span></li>
                        <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Email</span> <span class="font-bold"><?= $user['email']; ?></span></li>
                        <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Phone</span> <span class="font-bold"><?= $user['phone']; ?></span></li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <h3 class="text-lg mb-4" style="border-bottom:1px solid var(--gray-200); padding-bottom:0.5rem;">Need Help?</h3>
                    <p class="text-sm text-gray-600 mb-4">If you experience any technical difficulties or have questions about the submission process, please contact the secretariat.</p>
                    <button class="text-sm font-bold text-primary flex items-center" style="text-decoration:underline;">
                        <i data-lucide="mail" style="width:1rem; margin-right:0.5rem;"></i> Contact Support
                    </button>
                </div>
            </div>
        </div>

        <!-- Tab: Payment -->
        <div id="dash-tab-payment" class="dash-content">
            <h2 class="text-2xl mb-6">Payment Info & Upload</h2>

            <div class="grid md-grid-2">
                <div class="bg-gradient-primary p-8 rounded-2xl shadow-lg" style="color:white;">
                    <h3 class="text-xl mb-6 flex items-center"><i data-lucide="credit-card" style="margin-right:0.5rem;"></i> Transfer Details</h3>
                    <div style="display:flex; flex-direction:column; gap:1rem;">
                        <div>
                            <p style="font-size:0.875rem; opacity:0.8;">Registration Fee</p>
                            <p class="text-3xl font-extrabold">IDR 750.000 <span style="font-size:1.125rem; font-weight:normal;">/ USD 50</span></p>
                        </div>
                        <div style="padding-top:1rem; border-top:1px solid rgba(255,255,255,0.2);">
                            <p style="font-size:0.875rem; opacity:0.8;">Bank Name</p>
                            <p class="text-lg font-bold">Bank Mandiri</p>
                        </div>
                        <div>
                            <p style="font-size:0.875rem; opacity:0.8;">Account Number</p>
                            <p class="text-xl font-bold" style="letter-spacing:0.05em;">123-456-789-1011</p>
                        </div>
                        <div>
                            <p style="font-size:0.875rem; opacity:0.8;">Account Holder</p>
                            <p class="text-lg font-bold">Panitia GAINS Poltekkes Kemenkes JKT III</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border p-8">

                    <?php $p = $payment ?? null; ?>

                    <!-- STATUS VIEW -->
                    <?php if ($p && $p->status == 'approved'): ?>
                        <div class="form-group">
                            <h3 class="text-green-700 font-bold text-lg">✅ Payment Approved</h3>

                            <?php if (!empty($p->proof_file)): ?>
                                <img src="<?= base_url('public/uploads/open/approved.png'); ?>" style="max-width:200px; border-radius:8px;align:jusify;">
                                <div class="mt-2 text-success">
                                    ✔ File:
                                    <a href="<?= base_url('public/uploads/payment/' . $p->proof_file); ?>" target="_blank">
                                        <?= $p->proof_file; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                                <?php
                                $status = strtolower(trim((string)$user_status));

                                $map = [
                                    'registered' => [
                                        'text'  => 'You haven\'t completed your registration fee payment. Please proceed to the Payment Info & Upload tab to upload your proof of transfer and secure your spot',
                                        'color' => '#6c757d',
                                        'icon'  => 'user-plus'
                                    ],
                                    'pending' => [
                                        'text'  => 'Pending',
                                        'color' => '#ffc107',
                                        'icon'  => 'clock'
                                    ],
                                    'approved' => [
                                        'text'  => 'Your payment has been verified! However, you haven\'t selected a competition category or submitted your files yet. Please proceed to the My Submission tab to complete your application before the deadline (June 2026).',
                                        'color' => '#28a745',
                                        'icon'  => 'check-circle'
                                    ],
                                    'rejected' => [
                                        'text'  => 'Rejected',
                                        'color' => '#dc3545',
                                        'icon'  => 'x-circle'
                                    ],

                                ];

                                $data = $map[$status] ?? [
                                    'text'  => 'Unknown',
                                    'color' => '#999',
                                    'icon'  => 'help-circle'
                                ];
                                ?>

                                <!-- ICON -->
                                <i data-lucide="<?= $data['icon']; ?>"
                                    style="color:<?= $data['color']; ?>; margin-right:0.75rem; flex-shrink:0;">
                                </i>

                                <div>
                                    <h4 style="font-size:0.875rem; color:<?= $data['color']; ?>; margin-bottom:0.25rem;">
                                        <?= $data['text']; ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($p && $p->status == 'rejected'): ?>
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="text-red-700 font-bold text-lg">❌ Payment Rejected</h3>
                        <p class="text-red-600">Reason : <?= $p->comment; ?>. <br>Please upload a valid proof of payment.</p>

                        <?php $p = $payment ?? null; ?>

                        <form method="post" enctype="multipart/form-data" action="<?= base_url('dashboard/save_payment'); ?>">

                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="form-group">
                                <label class="form-label">Sender's Bank Name</label>
                                <input type="text" name="bank_name"
                                    value="<?= $p ? $p->bank_name : ''; ?>"
                                    required class="form-control"
                                    placeholder="e.g. Bank Central Asia (BCA)" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Sender's Account Name</label>
                                <input type="text" name="sender_name"
                                    value="<?= $p ? $p->sender_name : ''; ?>"
                                    required class="form-control"
                                    placeholder="e.g. Jane Doe" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Upload Receipt (JPG/PNG/PDF)</label>

                                <?php if (!empty($p->proof_file)): ?>
                                    <div class="mt-2 text-success">
                                        ✔ File:
                                        <a href="<?= base_url('public/uploads/payment/' . $p->proof_file); ?>" target="_blank">
                                            <?= $p->proof_file; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('uploaded_file')): ?>
                                    <div class="mt-2 text-success">
                                        ✔ File: <?= $this->session->flashdata('uploaded_file'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- hidden input -->
                                <input type="file"
                                    name="proof_file"
                                    id="proofInput"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    style="display:none;"
                                    required>

                                <!-- Upload box -->
                                <div id="uploadBox"
                                    style="border:2px dashed #ccc; border-radius:0.75rem; padding:1.5rem; text-align:center; background:#f9fafb; cursor:pointer; transition:.2s;">

                                    <p class="text-sm font-bold text-gray-600">
                                        Click or drag file here
                                    </p>
                                </div>

                                <!-- file name -->
                                <p id="fileLabel" class="text-sm text-gray-500 mt-2"></p>

                                <!-- preview -->
                                <div id="preview" class="mt-3"></div>
                            </div>

                            <button type="submit" class="btn btn-gradient w-full">
                                Submit Payment Proof
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- STATUS PENDING / BELUM ADA -->
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="text-lg mb-6">Upload Proof of Payment</h3>

                        <?php $p = $payment ?? null; ?>

                        <form method="post" enctype="multipart/form-data" action="<?= base_url('dashboard/save_payment'); ?>">

                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="form-group">
                                <label class="form-label">Sender's Bank Name</label>
                                <input type="text" name="bank_name"
                                    value="<?= $p ? $p->bank_name : ''; ?>"
                                    required class="form-control"
                                    placeholder="e.g. Bank Central Asia (BCA)" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Sender's Account Name</label>
                                <input type="text" name="sender_name"
                                    value="<?= $p ? $p->sender_name : ''; ?>"
                                    required class="form-control"
                                    placeholder="e.g. Jane Doe" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Upload Receipt (JPG/PNG/PDF)</label>

                                <?php if (!empty($p->proof_file)): ?>
                                    <div class="mt-2 text-success">
                                        ✔ File:
                                        <a href="<?= base_url('public/uploads/payment/' . $p->proof_file); ?>" target="_blank">
                                            <?= $p->proof_file; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('uploaded_file')): ?>
                                    <div class="mt-2 text-success">
                                        ✔ File: <?= $this->session->flashdata('uploaded_file'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- hidden input -->
                                <input type="file"
                                    name="proof_file"
                                    id="proofInput"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    style="display:none;"
                                    required>

                                <!-- Upload box -->
                                <div id="uploadBox"
                                    style="border:2px dashed #ccc; border-radius:0.75rem; padding:1.5rem; text-align:center; background:#f9fafb; cursor:pointer; transition:.2s;">

                                    <p class="text-sm font-bold text-gray-600">
                                        Click or drag file here
                                    </p>
                                </div>

                                <!-- file name -->
                                <p id="fileLabel" class="text-sm text-gray-500 mt-2"></p>

                                <!-- preview -->
                                <div id="preview" class="mt-3"></div>
                            </div>

                            <button type="submit" class="btn btn-gradient w-full">
                                Submit Payment Proof
                            </button>

                        </form>
                    <?php endif; ?>
                </div>

                <script>
                    const input = document.getElementById('proofInput');
                    const label = document.getElementById('fileLabel');
                    const box = document.getElementById('uploadBox');
                    const preview = document.getElementById('preview');

                    // klik box
                    box.addEventListener('click', () => input.click());

                    // drag over
                    box.addEventListener('dragover', e => {
                        e.preventDefault();
                        box.style.borderColor = 'blue';
                    });

                    // drag leave
                    box.addEventListener('dragleave', () => {
                        box.style.borderColor = '#ccc';
                    });

                    // drop file
                    box.addEventListener('drop', e => {
                        e.preventDefault();
                        input.files = e.dataTransfer.files;
                        input.dispatchEvent(new Event('change'));
                    });

                    // pilih file
                    input.addEventListener('change', function() {
                        const file = this.files[0];
                        if (!file) return;

                        // reset style
                        box.style.borderColor = '#ccc';

                        // validasi size
                        if (file.size > 5 * 1024 * 1024) {
                            alert('File terlalu besar (max 5MB)');
                            input.value = '';
                            preview.innerHTML = '';
                            if (label) label.innerText = '';
                            return;
                        }

                        // validasi type
                        const allowed = ['image/jpeg', 'image/png', 'application/pdf'];
                        if (!allowed.includes(file.type)) {
                            alert('Format tidak valid');
                            input.value = '';
                            preview.innerHTML = '';
                            if (label) label.innerText = '';
                            return;
                        }

                        // tampil nama file
                        if (label) label.innerText = file.name;

                        // preview
                        preview.innerHTML = '';

                        if (file.type.startsWith('image')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.innerHTML = `
                <img src="${e.target.result}" 
                     style="max-width:200px;border-radius:8px;">
            `;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.innerHTML = `<div>📄 ${file.name}</div>`;
                        }
                    });
                </script>
            </div>
        </div>

        <!-- Tab: Submission -->
        <div id="dash-tab-submission" class="dash-content">
            <h2 class="text-2xl mb-6">My Submission</h2>
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div class="p-8">

                    <?php $s = $submission ?? null; ?>

                    <?php if ($submission_status == 'finalist'): ?>
                        <div class="form-group">
                            <img src="<?= base_url('public/uploads/open/finalist.png'); ?>" style="max-width:100px; border-radius:8px;align:justify;">
                        </div>
                        <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                            <?php
                            $status = strtolower(trim((string)$submission_status));

                            $map = [
                                'registered' => [
                                    'text'  => 'Registered',
                                    'color' => '#6c757d',
                                    'icon'  => 'user-plus'
                                ],
                                'submitted' => [
                                    'text'  => 'Your submission has been successfully received and is currently under review by our expert panel. Please wait for the Acceptance Notification in August 2026.',
                                    'color' => '#17a2b8',
                                    'icon'  => 'search'
                                ],
                                'not selected' => [
                                    'text'  => 'Thank you for your valuable participation in GAINS 2026. Unfortunately, your submission was not selected for the final round this year. We highly appreciate your effort and encourage you to join us again next year.',
                                    'color' => '#343a40',
                                    'icon'  => 'slash'
                                ],
                                'finalist' => [
                                    'text'  => 'Congratulations! You have been shortlisted for the final round! Please check your email for presentation guidelines and confirm your physical/online attendance for the Conference & Final GAINS on 15-16 September 2026.',
                                    'color' => '#CFB53B',
                                    'icon'  => 'award'
                                ],
                            ];

                            $data = $map[$status] ?? [
                                'text'  => 'Unknown',
                                'color' => '#999',
                                'icon'  => 'help-circle'
                            ];
                            ?>

                            <!-- ICON -->
                            <i data-lucide="<?= $data['icon']; ?>"
                                style="color:<?= $data['color']; ?>; margin-right:0.75rem; flex-shrink:0;">
                            </i>

                            <div>
                                <h4 style="font-size:0.875rem; color:<?= $data['color']; ?>; margin-bottom:0.25rem;">
                                    <?= $data['text']; ?>
                                </h4>
                            </div>
                        </div>
                        <br>
                        <form method="post" action="<?= base_url('dashboard/save_submission'); ?>">
                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="form-group">
                                <label class="form-label">Institutional Affiliation <span class="text-primary">*</span></label>
                                <input type="text" name="institution" value="<?= $s->institution ?? '' ?>" required class="form-control" placeholder="e.g. Poltekkes Kemenkes Jakarta III" readonly />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Country <span class="text-primary">*</span></label>
                                <select onchange="handleCountryChange(this)" name="country" required class="form-control readonly-select">
                                    <option value="" disabled <?= empty($s) ? 'selected' : '' ?>>Select your country...</option>
                                    <?php
                                    $countries = ["Indonesia", "Malaysia", "Singapore", "Thailand", "Philippines", "Australia", "Japan", "India", "United States", "United Kingdom"];
                                    foreach ($countries as $c):
                                    ?>
                                        <option value="<?= $c ?>" <?= ($s && $s->country == $c) ? 'selected' : '' ?>>
                                            <?= $c ?>
                                        </option>
                                    <?php endforeach; ?>

                                    <option value="Other" <?= ($s && !in_array($s->country, $countries)) ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <div id="other-country-container" class="form-group <?= ($s && !in_array($s->country, $countries)) ? '' : 'hidden' ?> animate-fadeIn">
                                <label class="form-label">Please specify your country <span class="text-primary">*</span></label>
                                <input type="text" id="other-country-input" value="<?= ($s && !in_array($s->country, $countries)) ? $s->country : '' ?>" name="other_country" class="form-control" placeholder="Enter your country name" />
                            </div>

                            <div class="form-group" style="padding-top:1.5rem; border-top:1px solid var(--gray-100); margin-top:1.5rem;">
                                <label class="form-label mb-4">Select Competition Category <span class="text-primary">*</span></label>
                                <div class="grid md-grid-2" style="gap:rem;">
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="IRPC" <?= ($s && $s->category == 'IRPC') ? 'checked' : '' ?> readonly />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">IRPC</span>
                                            <span class="text-xs text-gray-500 mt-1">International Research Pitch</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>

                                    <label class="radio-card">
                                        <input type="radio" name="category" value="AHIC" <?= ($s && $s->category == 'AHIC') ? 'checked' : '' ?> readonly />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">AHIC</span>
                                            <span class="text-xs text-gray-500 mt-1">Innovation Challenge</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="E2IPBC" <?= ($s && $s->category == 'E2IPBC') ? 'checked' : '' ?> readonly />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">E2IPBC</span>
                                            <span class="text-xs text-gray-500 mt-1">Policy Brief</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mt-6">
                                <label class="form-label">Submission Title <span class="text-primary">*</span></label>
                                <input type="text" name="title" value="<?= $s->title ?? '' ?>" class="form-control" placeholder="Enter your research/innovation title" readonly />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Submission Link (Google Drive / Dropbox / YouTube) <span class="text-primary">*</span></label>
                                <div style="background:var(--info-bg); border:1px solid var(--info-border); padding:1rem; border-radius:0.75rem; margin-bottom:1rem;">
                                    <h4 class="text-sm flex items-center mb-2" style="color:var(--info-text);"><i data-lucide="info" style="width:1rem; margin-right:0.5rem;"></i> Upload Instructions & Criteria</h4>
                                    <ul style="list-style-type:disc; padding-left:1.25rem; font-size:0.75rem; color:var(--info-text); display:flex; flex-direction:column; gap:0.25rem;">
                                        <li>Create a single folder in your cloud storage (e.g., Google Drive) containing all your required submission files.</li>
                                        <li><strong>Document Formats:</strong> PDF or DOCX format for Abstracts, Policy Briefs, or Innovation Descriptions.</li>
                                        <li><strong>Video/Supporting Evidence (AHIC specifically):</strong> MP4 format or provide a YouTube link within your document (Max 5 minutes).</li>
                                        <li><strong>Access Permission:</strong> Ensure your folder link access is set to <strong>"Anyone with the link can view"</strong>.</li>
                                    </ul>
                                </div>
                                <div style="position:relative;">
                                    <i data-lucide="globe" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--gray-400);"></i>
                                    <input type="url" name="link" value="<?= $s->link ?? '' ?>" required class="form-control" style="padding-left:2.5rem;" placeholder="https://drive.google.com/drive/folders/..." readonly />
                                </div>
                            </div>

                            <div class="flex justify-end mt-8">
                                <button type="submit" class="btn btn-gradient text-lg"><?= $s ? 'Update Submission' : 'Save & Submit Document' ?></button>
                            </div>
                        </form>
                    <?php elseif ($submission_status == 'not selected'): ?>
                        <div class="form-group">
                            <h3 class="text-red-700 font-bold text-lg">❌ Submission Not Selected</h3>
                            <img src="<?= base_url('public/uploads/open/not_selected.png'); ?>" style="max-width:200px; border-radius:8px;align:justify;">
                        </div>
                        <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                            <?php
                            $status = strtolower(trim((string)$submission_status));

                            $map = [
                                'registered' => [
                                    'text'  => 'Registered',
                                    'color' => '#6c757d',
                                    'icon'  => 'user-plus'
                                ],
                                'submitted' => [
                                    'text'  => 'Your submission has been successfully received and is currently under review by our expert panel. Please wait for the Acceptance Notification in August 2026.',
                                    'color' => '#17a2b8',
                                    'icon'  => 'search'
                                ],
                                'not selected' => [
                                    'text'  => 'Thank you for your valuable participation in GAINS 2026. Unfortunately, your submission was not selected for the final round this year. We highly appreciate your effort and encourage you to join us again next year.',
                                    'color' => '#fa0808',
                                    'icon'  => 'timer-off'
                                ],
                                'finalist' => [
                                    'text'  => 'Congratulations! You have been shortlisted for the final round! Please check your email for presentation guidelines and confirm your physical/online attendance for the Conference & Final GAINS on 15-16 September 2026.',
                                    'color' => '#CFB53B',
                                    'icon'  => 'award'
                                ],
                            ];

                            $data = $map[$status] ?? [
                                'text'  => 'Unknown',
                                'color' => '#999',
                                'icon'  => 'help-circle'
                            ];
                            ?>

                            <!-- ICON -->
                            <i data-lucide="<?= $data['icon']; ?>"
                                style="color:<?= $data['color']; ?>; margin-right:0.75rem; flex-shrink:0;">
                            </i>

                            <div>
                                <h4 style="font-size:0.875rem; color:<?= $data['color']; ?>; margin-bottom:0.25rem;">
                                    <?= $data['text']; ?>
                                </h4>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if ($s): ?>
                            <div class="mb-4 text-success">
                                ✔ You have submitted before. You can update your submission.
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= base_url('dashboard/save_submission'); ?>">
                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="form-group">
                                <label class="form-label">Institutional Affiliation <span class="text-primary">*</span></label>
                                <input type="text" name="institution" value="<?= $s->institution ?? '' ?>" required class="form-control" placeholder="e.g. Poltekkes Kemenkes Jakarta III" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Country <span class="text-primary">*</span></label>
                                <select onchange="handleCountryChange(this)" name="country" required class="form-control">
                                    <option value="" disabled <?= empty($s) ? 'selected' : '' ?>>Select your country...</option>
                                    <?php
                                    $countries = ["Indonesia", "Malaysia", "Singapore", "Thailand", "Philippines", "Australia", "Japan", "India", "United States", "United Kingdom"];
                                    foreach ($countries as $c):
                                    ?>
                                        <option value="<?= $c ?>" <?= ($s && $s->country == $c) ? 'selected' : '' ?>>
                                            <?= $c ?>
                                        </option>
                                    <?php endforeach; ?>

                                    <option value="Other" <?= ($s && !in_array($s->country, $countries)) ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <div id="other-country-container" class="form-group <?= ($s && !in_array($s->country, $countries)) ? '' : 'hidden' ?> animate-fadeIn">
                                <label class="form-label">Please specify your country <span class="text-primary">*</span></label>
                                <input type="text" id="other-country-input" value="<?= ($s && !in_array($s->country, $countries)) ? $s->country : '' ?>" name="other_country" class="form-control" placeholder="Enter your country name" />
                            </div>

                            <div class="form-group" style="padding-top:1.5rem; border-top:1px solid var(--gray-100); margin-top:1.5rem;">
                                <label class="form-label mb-4">Select Competition Category <span class="text-primary">*</span></label>
                                <div class="grid md-grid-2" style="gap:rem;">
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="IRPC" <?= ($s && $s->category == 'IRPC') ? 'checked' : '' ?> />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">IRPC</span>
                                            <span class="text-xs text-gray-500 mt-1">International Research Pitch</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>

                                    <label class="radio-card">
                                        <input type="radio" name="category" value="AHIC" <?= ($s && $s->category == 'AHIC') ? 'checked' : '' ?> />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">AHIC</span>
                                            <span class="text-xs text-gray-500 mt-1">Innovation Challenge</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="E2IPBC" <?= ($s && $s->category == 'E2IPBC') ? 'checked' : '' ?> />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">E2IPBC</span>
                                            <span class="text-xs text-gray-500 mt-1">Policy Brief</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mt-6">
                                <label class="form-label">Submission Title <span class="text-primary">*</span></label>
                                <input type="text" name="title" value="<?= $s->title ?? '' ?>" class="form-control" placeholder="Enter your research/innovation title" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Submission Link (Google Drive / Dropbox / YouTube) <span class="text-primary">*</span></label>
                                <div style="background:var(--info-bg); border:1px solid var(--info-border); padding:1rem; border-radius:0.75rem; margin-bottom:1rem;">
                                    <h4 class="text-sm flex items-center mb-2" style="color:var(--info-text);"><i data-lucide="info" style="width:1rem; margin-right:0.5rem;"></i> Upload Instructions & Criteria</h4>
                                    <ul style="list-style-type:disc; padding-left:1.25rem; font-size:0.75rem; color:var(--info-text); display:flex; flex-direction:column; gap:0.25rem;">
                                        <li>Create a single folder in your cloud storage (e.g., Google Drive) containing all your required submission files.</li>
                                        <li><strong>Document Formats:</strong> PDF or DOCX format for Abstracts, Policy Briefs, or Innovation Descriptions.</li>
                                        <li><strong>Video/Supporting Evidence (AHIC specifically):</strong> MP4 format or provide a YouTube link within your document (Max 5 minutes).</li>
                                        <li><strong>Access Permission:</strong> Ensure your folder link access is set to <strong>"Anyone with the link can view"</strong>.</li>
                                    </ul>
                                </div>
                                <div style="position:relative;">
                                    <i data-lucide="globe" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--gray-400);"></i>
                                    <input type="url" name="link" value="<?= $s->link ?? '' ?>" required class="form-control" style="padding-left:2.5rem;" placeholder="https://drive.google.com/drive/folders/..." />
                                </div>
                            </div>

                            <div class="flex justify-end mt-8">
                                <button type="submit" class="btn btn-gradient text-lg"><?= $s ? 'Update Submission' : 'Save & Submit Document' ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab: Settings -->
        <div id="dash-tab-settings" class="dash-content">
            <h2 class="text-2xl mb-6">Account Settings</h2>
            <div class="grid md-grid-2">
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-lg mb-6 flex items-center"><i data-lucide="user-round" class="text-primary mr-2"></i> Update Profile</h3>
                        <?php if ($this->session->flashdata('success_update_profile')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success_update_profile'); ?></div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?= base_url('dashboard/update_profile'); ?>">

                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" value="<?= $user['name']; ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="<?= $user['email']; ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="<?= $user['phone']; ?>" required class="form-control">
                            </div>

                            <button type="submit" class="btn btn-dark w-full mt-4 text-lg">
                                Update Profile
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="max-width:32rem;">
                    <div class="p-8">
                        <h3 class="text-lg mb-6 flex items-center"><i data-lucide="key-round" class="text-primary mr-2"></i> Update Password</h3>
                        <?php if ($this->session->flashdata('success_update_password')): ?>
                            <div class="alert alert-success" id="password-success-alert">
                                <?= $this->session->flashdata('success_update_password'); ?>
                                <br><small>You will be automatically logged out in <span id="countdown">10</span> seconds for security reasons.</small>
                            </div>
                            <script>
                                // Auto logout countdown after password change
                                let countdown = 10;
                                const countdownElement = document.getElementById('countdown');

                                const timer = setInterval(() => {
                                    countdown--;
                                    countdownElement.textContent = countdown;

                                    if (countdown <= 0) {
                                        clearInterval(timer);
                                        window.location.href = '<?= base_url('auth/logout'); ?>';
                                    }
                                }, 1000);
                            </script>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?= base_url('dashboard/update_password'); ?>">

                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" required class="form-control">
                            </div>

                            <button type="submit" class="btn btn-dark w-full mt-4 text-lg">
                                Save Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>