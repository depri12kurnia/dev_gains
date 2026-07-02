<?php if ($this->ion_auth->in_group('participant')) {  ?>
    <!-- Registration Status -->
    <?php
    $detail = isset($detail) ? $detail : null;

    $payment_status = $detail->payment_status ?? null;
    $payment_comment = $detail->payment_comment ?? null;
    $payment = (object) [
        'status'      => $payment_status,
        'comment'     => $payment_comment,
        'proof_file'  => $detail->proof_file ?? null,
        'bank_name'   => $detail->bank_name ?? '',
        'sender_name' => $detail->sender_name ?? ''
    ];

    $submission_status = $detail->submission_status ?? null;
    // If controller provided a full `$submission` object (from M_submission), keep it.
    // Otherwise, build a lightweight fallback from $detail (which contains limited fields).
    $submission = $submission ?? (object) [
        'status'      => $submission_status,
        'title'       => $detail->submission_title ?? '',
        'country'     => $detail->country ?? '',
        'category'    => $detail->category ?? '',
        'link'        => $detail->link ?? '',
        'institution' => $detail->institution ?? ''
    ];

    if (!isset($user)) {
        $user = (object) [
            'name'  => '',
            'email' => '',
            'phone' => ''
        ];
    } elseif (is_array($user)) {
        $user = (object) $user;
    }

    $user_status = $user_status ?? ($payment_status ?: 'registered');

    $status_payment = $payment_status ?: $user_status;
    $progress_payment = 20;
    if ($status_payment === 'pending' || $status_payment === 'rejected') {
        $progress_payment = 60;
    } elseif ($status_payment === 'approved') {
        $progress_payment = 100;
    }

    $status_submission = $submission_status ?: 'registered';
    $progress_submission = 20;
    if ($status_submission === 'submitted' || $status_submission === 'revision') {
        $progress_submission = 60;
    } elseif ($status_submission === 'not_selected' || $status_submission === 'finalist') {
        $progress_submission = 100;
    }
    ?>
    <!-- End registration status -->

    <div class="dash-sidebar">
        <!-- Participant -->
        <div class="flex items-center mb-8" style="gap:0.75rem;">
            <div>
                <h3 style="font-size:0.7rem; margin:0;"><?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></h3>
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

            <?php if ($this->session->flashdata('message')): ?>
                <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex; align-items:center;">
                    <div>
                        <?= $this->session->flashdata('message'); ?>
                    </div>

                    <?php if (empty($this->session->userdata('phone'))): ?>
                        <a href="javascript:void(0)" class="ml-auto" onclick="switchDashboardTab('settings')" id="tab-btn-settings" style="font-weight: bold; text-decoration: underline;">
                            Update Your Phone Number !
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <!-- Payment and Submission Status  -->
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
                                                                                                                                                                                                                'submitted'  => 'Submitted',
                                                                                                                                                                                                                'under review' => 'Under Review',
                                                                                                                                                                                                                'not_selected' => 'Not Selected',
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

                        <!-- Step 1: Registered -->
                        <span class="<?= in_array($status, ['registered', 'pending', 'approved', 'submitted', 'finalist', 'not_selected']) ? 'text-primary font-bold' : 'text-gray-400' ?>">
                            Registered
                        </span>

                        <!-- Step 2: Payment -->
                        <span class="<?= in_array($status, ['pending', 'approved', 'submitted', 'finalist', 'not_selected']) ? 'text-primary font-bold' : 'text-gray-400' ?>">
                            Payment
                            <?php if ($status == 'rejected'): ?>
                                <div class="alert alert-danger mt-2" style="font-size: 0.75rem;">
                                    Your payment was rejected. Please re-upload proof of payment.
                                </div>
                            <?php endif; ?>
                        </span>

                        <!-- Step 3: Approved/Submission -->
                        <span class="<?= in_array($status, ['approved', 'submitted', 'under review', 'finalist', 'not_selected']) ? 'text-primary font-bold' : 'text-gray-400' ?>">
                            Verified & Submission
                        </span>

                    </div>
                </div>
                <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                    <?php
                    $status = strtolower(trim((string)$user_status));

                    $map = [
                        'registered' => [
                            'title' => 'Awaiting Payment',
                            'text'  => 'You haven\'t uploaded your registration fee payment. Please proceed to the <b>Payment Info</b> tab to secure your spot.',
                            'color' => '#6c757d',
                            'icon'  => 'user-plus'
                        ],
                        'pending' => [
                            'title' => 'Payment Under Verification',
                            'text'  => 'Your proof of payment has been uploaded and is currently being verified by our team. Please check back later.',
                            'color' => '#ffc107',
                            'icon'  => 'clock'
                        ],
                        'approved' => [
                            'title' => 'Payment Verified',
                            'text'  => 'Your payment is confirmed! Now, please complete your <b>Submission</b> (category & files) before the deadline (June 2026).',
                            'color' => '#28a745',
                            'icon'  => 'check-circle'
                        ],
                        'rejected' => [
                            'title' => 'Payment Rejected',
                            'text'  => 'We couldn\'t verify your payment. Note: ' . ($payment_comment ?? 'Please re-upload a valid proof of transfer.'),
                            'color' => '#dc3545',
                            'icon'  => 'x-circle'
                        ],
                        'submitted' => [
                            'title' => 'Work Submitted',
                            'text'  => 'Your work has been received and is currently in the <b>Judging Process</b>. Good luck!',
                            'color' => '#17a2b8',
                            'icon'  => 'file-text'
                        ],
                        'under review' => [
                            'title' => 'Under Review',
                            'text'  => 'Your work is currently being reviewed by our panel. Please check back later for updates.',
                            'color' => '#ffc107',
                            'icon'  => 'clock'
                        ],
                        'finalist' => [
                            'title' => 'Congratulations!',
                            'text'  => 'You have been selected as a <b>Finalist</b>! Check your email for the next steps regarding the final presentation.',
                            'color' => '#6610f2',
                            'icon'  => 'trophy'
                        ],
                        'not_selected' => [
                            'title' => 'Announcement',
                            'text'  => 'Thank you for your participation. Unfortunately, you haven\'t made it to the final round this time. Keep spirit!',
                            'color' => '#dc3545',
                            'icon'  => 'info'
                        ],
                    ];

                    $data = $map[$status] ?? [
                        'title' => 'Status Unknown',
                        'text'  => 'Please contact the administrator.',
                        'color' => '#999',
                        'icon'  => 'help-circle'
                    ];
                    ?>

                    <!-- ICON -->
                    <i data-lucide="<?= $data['icon']; ?>"
                        style="color:<?= $data['color']; ?>; margin-right:0.75rem; flex-shrink:0; width: 24px; height: 24px;">
                    </i>

                    <div>
                        <h4 style="font-size:1rem; font-weight:bold; color:<?= $data['color']; ?>; margin-bottom:0.25rem;">
                            <?= $data['title']; ?>
                        </h4>
                        <p style="font-size:0.875rem; color:#555; margin:0;">
                            <?= $data['text']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Payment and Submission Status -->
            </br>
            <div class="grid md-grid-2">
                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <h3 class="text-lg mb-4" style="border-bottom:1px solid var(--gray-200); padding-bottom:0.5rem;">Profile Information</h3>
                    <ul style="display:flex; flex-direction:column; gap:0.75rem; font-size:0.875rem;">
                        <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Full Name</span> <span class="font-bold"><?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></span></li>
                        <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Email</span> <span class="font-bold"><?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></span></li>
                        <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Phone</span>
                            <span class="font-bold"><?= htmlspecialchars($user->phone, ENT_QUOTES, 'UTF-8'); ?>
                                <?php if (empty($this->session->userdata('phone'))): ?>
                                    <a href="javascript:void(0)" class="ml-auto" onclick="switchDashboardTab('settings')" id="tab-btn-settings" style="font-weight: bold; text-decoration: underline;">
                                        Update Your Phone Number
                                    </a>
                                <?php endif; ?>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <h3 class="text-lg mb-4" style="border-bottom:1px solid var(--gray-200); padding-bottom:0.5rem;">Need Help?</h3>
                    <p class="text-sm text-gray-600 mb-4">If you experience any technical difficulties or have questions about the submission process, please contact the secretariat.</p>
                    <a href="mailto:gains@poltekkesjakarta3.ac.id" target="_blank">
                        <button class="text-sm font-bold text-primary flex items-center" style="text-decoration:underline;">
                            <i data-lucide="mail" style="width:1rem; margin-right:0.5rem;"></i> Email Contact Support
                        </button>
                    </a>
                    <a href="http://wa.me/628138878933" target="_blank">
                        <button class="text-sm font-bold text-primary flex items-center" style="text-decoration:underline;">
                            <i data-lucide="phone" style="width:1rem; margin-right:0.5rem;"></i> Whatsapp Contact Support
                        </button>
                    </a>
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
                            <p class="text-3xl font-extrabold">IDR 250.000 <span style="font-size:1.125rem; font-weight:normal;">/ USD 15</span></p>
                        </div>
                        <div style="padding-top:1rem; border-top:1px solid rgba(255,255,255,0.2);">
                            <p style="font-size:0.875rem; opacity:0.8;">Bank Name</p>
                            <p class="text-lg font-bold">BNI (Bank Negara Indonesia)</p>
                        </div>
                        <div>
                            <p style="font-size:0.875rem; opacity:0.8;">Account Number</p>
                            <p class="text-xl font-bold" style="letter-spacing:0.05em;">1793324297</p>
                        </div>
                        <div>
                            <p style="font-size:0.875rem; opacity:0.8;">Account Holder</p>
                            <p class="text-lg font-bold">RPL 182 BLU POLTEKKES 3 UTK DK BNI</p>
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
                                'under review' => [
                                    'text'  => 'Your submission is currently under review by our expert panel. Please wait for the Acceptance Notification in August 2026.',
                                    'color' => '#ffc107',
                                    'icon'  => 'clock'
                                ],
                                'submitted' => [
                                    'text'  => 'Your submission has been successfully received and is currently under review by our expert panel. Please wait for the Acceptance Notification in August 2026.',
                                    'color' => '#17a2b8',
                                    'icon'  => 'search'
                                ],

                                'not_selected' => [
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
                        <!-- View Recommendations -->
                        <?php if (!empty($judges_comments)): ?>
                            <div style="margin-top: 2.5rem; border-top: 1px solid #e2e8f0; padding-top: 2rem;">

                                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="message-square-code" style="color: #3b82f6; width: 22px; height: 22px;"></i>
                                    Review & Feedback from Expert Panel (Judges)
                                </h3>

                                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                    <?php $no = 1;
                                    foreach ($judges_comments as $comment): ?>
                                        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; shadow-sm">

                                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                    <span style="background: #3b82f6; color: #ffffff; font-weight: 700; border-radius: 50%; text-align: center; display: inline-block; width: 28px; height: 28px; line-height: 28px; font-size: 0.85rem;">
                                                        <?= $no; ?>
                                                    </span>
                                                    <h5 style="font-weight: 700; color: #0f172a; font-size: 0.95rem; margin: 0;">
                                                        Reviewer Panelist <?= $no; ?>
                                                    </h5>
                                                </div>

                                                <div>
                                                    <?php
                                                    $rec_status = $comment['recommendation_status'];
                                                    if ($rec_status == 'Qualified for the Final Round'): ?>
                                                        <span style="background-color: #d1fae5; color: #065f46; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-trophy"></i> Final Round
                                                        </span>
                                                    <?php elseif ($rec_status == 'Qualified with Minor Revisions'): ?>
                                                        <span style="background-color: #fef3c7; color: #92400e; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-tools"></i> Minor Revision
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="background-color: #fee2e2; color: #991b1b; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-times-circle"></i> Not Selected
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.875rem;">

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #059669; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-plus-circle"></i> KEY STRENGTHS
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['key_strengths']) ? nl2br(htmlspecialchars($comment['key_strengths'])) : '<span style="color: #94a3b8; font-style: italic;">No specific strengths commented.</span>'; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #dc2626; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-minus-circle"></i> KEY WEAKNESSES
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['key_weaknesses']) ? nl2br(htmlspecialchars($comment['key_weaknesses'])) : '<span style="color: #94a3b8; font-style: italic;">No specific weaknesses commented.</span>'; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #2563eb; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-lightbulb"></i> CONSTRUCTIVE RECOMMENDATIONS
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['recommendations']) ? nl2br(htmlspecialchars($comment['recommendations'])) : '<span style="color: #94a3b8; font-style: italic;">No specific recommendations provided.</span>'; ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php $no++;
                                    endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php elseif ($submission_status == 'revision'): ?>
                        <div class="form-group">
                            <img src="<?= base_url('public/uploads/open/revision.png'); ?>" style="max-width:100px; border-radius:8px;align:justify;">
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
                                'revision' => [
                                    'text'  => 'Your submission is revision please check judges comments',
                                    'color' => '#ffc107',
                                    'icon'  => 'clock'
                                ],
                                'submitted' => [
                                    'text'  => 'Your submission has been successfully received and is currently under review by our expert panel. Please wait for the Acceptance Notification in August 2026.',
                                    'color' => '#17a2b8',
                                    'icon'  => 'search'
                                ],

                                'not_selected' => [
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
                        <!-- View Recommendations -->
                        <?php if (!empty($judges_comments)): ?>
                            <div style="margin-top: 2.5rem; border-top: 1px solid #e2e8f0; padding-top: 2rem;">

                                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="message-square-code" style="color: #3b82f6; width: 22px; height: 22px;"></i>
                                    Review & Feedback from Expert Panel (Judges)
                                </h3>

                                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                    <?php $no = 1;
                                    foreach ($judges_comments as $comment): ?>
                                        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; shadow-sm">

                                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                    <span style="background: #3b82f6; color: #ffffff; font-weight: 700; border-radius: 50%; text-align: center; display: inline-block; width: 28px; height: 28px; line-height: 28px; font-size: 0.85rem;">
                                                        <?= $no; ?>
                                                    </span>
                                                    <h5 style="font-weight: 700; color: #0f172a; font-size: 0.95rem; margin: 0;">
                                                        Reviewer Panelist <?= $no; ?>
                                                    </h5>
                                                </div>

                                                <div>
                                                    <?php
                                                    $rec_status = $comment['recommendation_status'];
                                                    if ($rec_status == 'Qualified for the Final Round'): ?>
                                                        <span style="background-color: #d1fae5; color: #065f46; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-trophy"></i> Final Round
                                                        </span>
                                                    <?php elseif ($rec_status == 'Qualified with Minor Revisions'): ?>
                                                        <span style="background-color: #fef3c7; color: #92400e; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-tools"></i> Minor Revision
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="background-color: #fee2e2; color: #991b1b; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-times-circle"></i> Not Selected
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.875rem;">

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #059669; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-plus-circle"></i> KEY STRENGTHS
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['key_strengths']) ? nl2br(htmlspecialchars($comment['key_strengths'])) : '<span style="color: #94a3b8; font-style: italic;">No specific strengths commented.</span>'; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #dc2626; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-minus-circle"></i> KEY WEAKNESSES
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['key_weaknesses']) ? nl2br(htmlspecialchars($comment['key_weaknesses'])) : '<span style="color: #94a3b8; font-style: italic;">No specific weaknesses commented.</span>'; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #2563eb; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-lightbulb"></i> CONSTRUCTIVE RECOMMENDATIONS
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['recommendations']) ? nl2br(htmlspecialchars($comment['recommendations'])) : '<span style="color: #94a3b8; font-style: italic;">No specific recommendations provided.</span>'; ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php $no++;
                                    endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php elseif ($submission_status == 'not_selected'): ?>
                        <div class="form-group">
                            <h3 class="text-red-700 font-bold text-lg">❌ Submission Not Selected</h3>
                            <img src="<?= base_url('public/uploads/open/not_selected.png'); ?>" style="max-width:200px; border-radius:8px;align:justify;">
                        </div>
                        <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                            <?php
                            $status = strtolower(trim((string)$submission_status));

                            $map = [

                                'not_selected' => [
                                    'text'  => 'Thank you for your valuable participation in GAINS 2026. Unfortunately, your submission was not selected for the final round this year. We highly appreciate your effort and encourage you to join us again next year.',
                                    'color' => '#fa0808',
                                    'icon'  => 'timer-off'
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
                        <?php if ($status === 'submitted'): ?>
                            <div class="mb-4 text-success">
                                ✔ You have submitted before. You can update your submission.
                            </div>
                        <?php endif; ?>
                        <!-- View Recommendations -->
                        <?php if (!empty($judges_comments)): ?>
                            <div style="margin-top: 2.5rem; border-top: 1px solid #e2e8f0; padding-top: 2rem;">

                                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="message-square-code" style="color: #3b82f6; width: 22px; height: 22px;"></i>
                                    Review & Feedback from Expert Panel (Judges)
                                </h3>

                                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                    <?php $no = 1;
                                    foreach ($judges_comments as $comment): ?>
                                        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; shadow-sm">

                                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                    <span style="background: #3b82f6; color: #ffffff; font-weight: 700; border-radius: 50%; text-align: center; display: inline-block; width: 28px; height: 28px; line-height: 28px; font-size: 0.85rem;">
                                                        <?= $no; ?>
                                                    </span>
                                                    <h5 style="font-weight: 700; color: #0f172a; font-size: 0.95rem; margin: 0;">
                                                        Reviewer Panelist <?= $no; ?>
                                                    </h5>
                                                </div>

                                                <div>
                                                    <?php
                                                    $rec_status = $comment['recommendation_status'];
                                                    if ($rec_status == 'Qualified for the Final Round'): ?>
                                                        <span style="background-color: #d1fae5; color: #065f46; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-trophy"></i> Final Round
                                                        </span>
                                                    <?php elseif ($rec_status == 'Qualified with Minor Revisions'): ?>
                                                        <span style="background-color: #fef3c7; color: #92400e; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-tools"></i> Minor Revision
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="background-color: #fee2e2; color: #991b1b; padding: 0.35rem 1rem; font-weight: 700; border-radius: 9999px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                            <i class="fas fa-times-circle"></i> Not Selected
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.875rem;">

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #059669; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-plus-circle"></i> KEY STRENGTHS
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['key_strengths']) ? nl2br(htmlspecialchars($comment['key_strengths'])) : '<span style="color: #94a3b8; font-style: italic;">No specific strengths commented.</span>'; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #dc2626; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-minus-circle"></i> KEY WEAKNESSES
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['key_weaknesses']) ? nl2br(htmlspecialchars($comment['key_weaknesses'])) : '<span style="color: #94a3b8; font-style: italic;">No specific weaknesses commented.</span>'; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span style="display: block; font-weight: 700; color: #2563eb; font-size: 0.75rem; text-uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                                                        <i class="fas fa-lightbulb"></i> CONSTRUCTIVE RECOMMENDATIONS
                                                    </span>
                                                    <div style="color: #334155; background: #ffffff; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; line-height: 1.5;">
                                                        <?= !empty($comment['recommendations']) ? nl2br(htmlspecialchars($comment['recommendations'])) : '<span style="color: #94a3b8; font-style: italic;">No specific recommendations provided.</span>'; ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php $no++;
                                    endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= base_url('dashboard/save_submission'); ?>" enctype="multipart/form-data">
                            <input type="hidden"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">

                            <!-- SECTION A: Participant Data -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <i data-lucide="users-round"></i> Section A: Participant Data
                                </h4>

                                <div class="grid-2">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-secondary">Team Leader (Full Name) <span class="text-danger">*</span></label>
                                        <input type="text" name="team_leader" value="<?= $s->team_leader ?? '' ?>" class="form-control" placeholder="e.g. Jane Doe" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-secondary">Academic/Professional Titles <span class="text-danger">*</span></label>
                                        <input type="text" name="leader_titles" value="<?= $s->leader_titles ?? '' ?>" class="form-control" placeholder="e.g. Dr., M.Sc." required>
                                    </div>
                                </div>

                                <div class="grid-2">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-secondary">Institutional Affiliation <span class="text-danger">*</span></label>
                                        <input type="text" name="institution" value="<?= $s->institution ?? '' ?>" class="form-control" placeholder="e.g. Poltekkes Kemenkes Jakarta III" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-secondary">Country <span class="text-danger">*</span></label>
                                        <select id="countrySelect" name="country" class="form-select" required>
                                            <option value="" disabled <?= empty($s->country ?? '') ? 'selected' : '' ?>>Select your country...</option>
                                            <?php
                                            $countries = ["Indonesia", "Malaysia", "Singapore", "Thailand", "Philippines", "Australia", "Japan", "India", "United States", "United Kingdom"];
                                            foreach ($countries as $c):
                                            ?>
                                                <option value="<?= $c ?>" <?= (($s->country ?? '') === $c) ? 'selected' : '' ?>><?= $c ?></option>
                                            <?php endforeach; ?>
                                            <option value="Other" <?= (($s->country ?? '') && !in_array($s->country ?? '', $countries)) ? 'selected' : '' ?>>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="otherCountryDiv" class="mb-4 <?= (($s->country ?? '') && !in_array($s->country ?? '', $countries)) ? '' : 'd-none-custom' ?>">
                                    <label class="form-label fw-medium text-secondary">Please specify your country <span class="text-danger">*</span></label>
                                    <input type="text" id="otherCountryInput" name="other_country" value="<?= (($s->country ?? '') && !in_array($s->country ?? '', $countries)) ? $s->country : '' ?>" class="form-control" placeholder="Enter your country name">
                                </div>

                                <div class="grid-2">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-secondary mb-2">Participation Type <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="partType" id="typeIndividual" value="Individual" <?= (($s->partType ?? 'Individual') === 'Individual') ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="typeIndividual">Individual</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="partType" id="typeTeam" value="Team" <?= (($s->partType ?? '') === 'Team') ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="typeTeam">Team (Max 3)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-secondary mb-2">Cross-institutional/country collaboration? <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="crossCollab" id="collabYes" value="Yes" <?= (($s->crossCollab ?? '') === 'Yes') ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="collabYes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="crossCollab" id="collabNo" value="No" <?= (($s->crossCollab ?? '') === 'No') ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="collabNo">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="teamMembersDiv" class="p-3 bg-light rounded-3 border <?= (($s->partType ?? '') === 'Team') ? '' : 'd-none-custom' ?>">
                                    <label class="form-label fw-medium text-secondary">Names and Affiliations of Team Members</label>
                                    <textarea id="teamMembersInput" name="team_members" rows="3" class="form-control" placeholder="1. Name, Title - Affiliation&#10;2. Name, Title - Affiliation"><?= $s->team_members ?? '' ?></textarea>
                                </div>
                            </div>

                            <!-- SECTION B: Main Competition -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <i data-lucide="award"></i> Section B: Main Competition
                                </h4>

                                <label class=" form-label fw-medium text-secondary mb-3">Select Competition Category <span class="text-danger">*</span></label>
                                <div class="radio-card-grid">
                                    <div class="form-group">
                                        <input type="radio" name="category" id="catIRPC" value="IRPC" class="radio-card-input" <?= (($s->category ?? '') === 'IRPC') ? 'checked' : '' ?> required>
                                        <label for="catIRPC" class="radio-card-label w-100">
                                            <div class="flex-grow-1">
                                                <span class="d-block fw-bold text-dark">IRPC</span>
                                                <span class="d-block small text-muted mt-1">International Research Pitch</span>
                                            </div>
                                            <i class="bi bi-check-circle-fill fs-5 text-primary-custom check-icon d-none"></i>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="category" id="catAHIC" value="AHIC" class="radio-card-input" <?= (($s->category ?? '') === 'AHIC') ? 'checked' : '' ?> required>
                                        <label for="catAHIC" class="radio-card-label w-100">
                                            <div class="flex-grow-1">
                                                <span class="d-block fw-bold text-dark">AHIC</span>
                                                <span class="d-block small text-muted mt-1">Innovation Challenge</span>
                                            </div>
                                            <i class="bi bi-check-circle-fill fs-5 text-primary-custom check-icon d-none"></i>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="category" id="catE2IPBC" value="E2IPBC" class="radio-card-input" <?= (($s->category ?? '') === 'E2IPBC') ? 'checked' : '' ?> required>
                                        <label for="catE2IPBC" class="radio-card-label w-100">
                                            <div class="flex-grow-1">
                                                <span class="d-block fw-bold text-dark">E2IPBC</span>
                                                <span class="d-block small text-muted mt-1">Policy Brief</span>
                                            </div>
                                            <i class="bi bi-check-circle-fill fs-5 text-primary-custom check-icon d-none"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION C: Submission Information -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <i data-lucide="file-text"></i> Section C: Submission Information
                                </h4>

                                <div class=" mb-4">
                                    <label class="form-label fw-medium text-secondary">Submission Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="<?= $s->title ?? '' ?>" class="form-control py-2 rounded-3" placeholder="Enter your full research or innovation title" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium text-secondary">Focus Area <span class="text-danger">*</span></label>
                                    <select id="areaSelect" name="focus_area" class="form-select py-2 rounded-3" required>
                                        <option value="" disabled <?= empty($s->focus_area ?? '') ? 'selected' : '' ?>>Select focus area...</option>

                                        <?php
                                        $focusAreas = ["NCDs", "Women's Health", "NCDs and Women's Health", "Health Education", "Healthcare Services", "Health Policy"];
                                        foreach ($focusAreas as $area):
                                        ?>
                                            <option value="<?= $area ?>" <?= (($s->focus_area ?? '') === $area) ? 'selected' : '' ?>><?= $area ?></option>
                                        <?php endforeach; ?>

                                        <option value="Other" <?= (($s->focus_area ?? '') && !in_array($s->focus_area, $focusAreas)) ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div>

                                <div id="otherAreaDiv" class="mb-4 <?= (!empty($s->focus_area ?? '') && !in_array($s->focus_area, $focusAreas)) ? '' : 'd-none-custom' ?>">
                                    <label class="form-label fw-medium text-secondary">Please specify your focus area <span class="text-danger">*</span></label>
                                    <input type="text" id="otherAreaInput" name="other_area" value="<?= (!empty($s->focus_area ?? '') && !in_array($s->focus_area, $focusAreas)) ? $s->focus_area : '' ?>" class="form-control" placeholder="Enter your focus area">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium text-secondary">Alignment of the work with the GAINS 2026 theme <span class="text-danger">*</span></label>
                                    <textarea name="alignment_theme" rows="3" class="form-control py-2 rounded-3" placeholder="Briefly describe how your submission aligns with the main theme..." required><?= $s->alignment_theme ?? '' ?></textarea>
                                </div>
                            </div>

                            <!-- SECTION D: File Upload -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <i data-lucide=" shield-check"></i> Section D: Link Upload
                                </h4>
                                <label class="form-label">Main Document (Google Drive / Dropbox)<span class="text-primary">*</span></label>
                                <div style="position:relative;">
                                    <i data-lucide="globe" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--gray-400);"></i>
                                    <input type="url" name="link" value="<?= $s->link ?? '' ?>" required class="form-control" style="padding-left:2.5rem;" placeholder="Example : https://drive.google.com/drive/folders/..." />
                                </div>
                                </br>
                                <label class="form-label">Supporting Documents (Google Drive / Dropbox / YouTube) Additional</label>
                                <div style="position:relative;">
                                    <i data-lucide="globe" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--gray-400);"></i>
                                    <input type="url" name="supporting_links" value="<?= $s->supporting_links ?? '' ?>" class="form-control" style="padding-left:2.5rem;" placeholder="Example: https://drive.google.com/drive/folders/..." />
                                </div>
                            </div>
                            <!-- SECTION E: Participant Consent & Declaration -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <i data-lucide="shield-check"></i> Section E: Participant Consent & Declaration
                                </h4>

                                <div class="consent-box">
                                    <p>By submitting this form, you agree to the declaration statement regarding originality,
                                        academic ethics, and compliance with the committee's regulation:</p>

                                    <ul class="consent-list">
                                        <li><strong>Originality of Work:</strong> The submitted work is an original creation
                                            and/or
                                            the collective work of the designated team members.</li>
                                        <li><strong>Academic Integrity & Copyright:</strong> The work does not infringe upon any
                                            third-party copyright, intellectual property rights, or breach established academic
                                            ethical standards.</li>
                                        <li><strong>Compliance with Rules:</strong> I/We agree to strictly abide by all the
                                            guidelines, rules, regulations, and provisions established by the GAINS 2026
                                            organizing
                                            committee.</li>
                                        <li><strong>Communication Consent:</strong> I/We agree to be contacted by the organizing
                                            committee via the official email address and contact details provided in the
                                            registration
                                            form.</li>
                                        <li><strong>Finality of Decisions:</strong> I/We fully understand and acknowledge that
                                            the
                                            decisions made by the reviewer panel are final, binding, and not subject to appeal.
                                        </li>
                                    </ul>

                                    <label class="consent-checkbox">
                                        <input type="checkbox" name="consent" required <?= ($s->consent ?? 0) ? 'checked' : '' ?>>
                                        <span class="consent-label">
                                            I/We have read, fully understand, and agree to the Participant Consent and
                                            Declaration statement above.
                                            <span class="text-danger">*</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-8">
                                <button type="submit" class="btn btn-gradient text-lg"><?= $status === 'submitted' ? 'Update Submission' : 'Save & Submit Registration' ?></button>
                            </div>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const countrySelect = document.getElementById('countrySelect');
                                const otherCountryDiv = document.getElementById('otherCountryDiv');
                                const otherCountryInput = document.getElementById('otherCountryInput');
                                const otherAreaDiv = document.getElementById('otherAreaDiv');
                                const otherAreaInput = document.getElementById('otherAreaInput');
                                const teamRadios = document.querySelectorAll('input[name="partType"]');
                                const teamMembersDiv = document.getElementById('teamMembersDiv');
                                const teamMembersInput = document.getElementById('teamMembersInput');
                                const categoryRadios = document.querySelectorAll('input[name="category"]');

                                function updateCountry() {
                                    if (!countrySelect) return;
                                    if (countrySelect.value === 'Other') {
                                        otherCountryDiv.classList.remove('d-none-custom');
                                        otherCountryInput.required = true;
                                    } else {
                                        otherCountryDiv.classList.add('d-none-custom');
                                        otherCountryInput.required = false;
                                    }
                                }

                                function updateArea() {
                                    if (!areaSelect) return;
                                    if (areaSelect.value === 'Other') {
                                        otherAreaDiv.classList.remove('d-none-custom');
                                        otherAreaInput.required = true;
                                    } else {
                                        otherAreaDiv.classList.add('d-none-custom');
                                        otherAreaInput.required = false;
                                    }
                                }

                                function updateTeamMembers() {
                                    const selected = Array.from(teamRadios).find(r => r.checked);
                                    if (selected && selected.value === 'Team') {
                                        teamMembersDiv.classList.remove('d-none-custom');
                                        teamMembersInput.required = true;
                                    } else {
                                        teamMembersDiv.classList.add('d-none-custom');
                                        teamMembersInput.required = false;
                                    }
                                }

                                if (countrySelect) {
                                    countrySelect.addEventListener('change', updateCountry);
                                    updateCountry();
                                }

                                if (areaSelect) {
                                    areaSelect.addEventListener('change', updateArea);
                                    updateArea();
                                }

                                teamRadios.forEach(radio => radio.addEventListener('change', updateTeamMembers));

                                updateTeamMembers();
                            });
                        </script>

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
                                <input type="text" name="first_name" value="<?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($user->phone, ENT_QUOTES, 'UTF-8'); ?>" required class="form-control">
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