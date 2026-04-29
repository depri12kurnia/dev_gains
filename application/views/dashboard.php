<!-- PAGE: DASHBOARD -->
<div id="page-dashboard" class="page-section" style="padding:0;" active>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="dash-sidebar">
            <div class="flex items-center mb-8" style="gap:0.75rem;">
                <div style="width:3rem; height:3rem; border-radius:50%; background:var(--primary); color:white; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:1.25rem;">
                    JD
                </div>
                <div>
                    <h3 style="font-size:1rem; margin:0;">Dr. Jane Doe</h3>
                    <span class="text-gray-500" style="font-size:0.75rem;">Participant</span>
                </div>
            </div>

            <nav>
                <button onclick="switchDashboardTab('overview')" id="tab-btn-overview" class="dash-tab-btn active">
                    <i data-lucide="layout-dashboard" style="width:1.25rem;"></i> Overview
                </button>
                <button onclick="switchDashboardTab('payment')" id="tab-btn-payment" class="dash-tab-btn">
                    <i data-lucide="credit-card" style="width:1.25rem;"></i> Payment Info
                </button>
                <button onclick="switchDashboardTab('submission')" id="tab-btn-submission" class="dash-tab-btn">
                    <i data-lucide="upload" style="width:1.25rem;"></i> My Submission
                </button>
                <button onclick="switchDashboardTab('settings')" id="tab-btn-settings" class="dash-tab-btn">
                    <i data-lucide="settings" style="width:1.25rem;"></i> Settings
                </button>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="dash-main">

            <!-- Tab: Overview -->
            <div id="dash-tab-overview" class="dash-content active">
                <h2 class="text-2xl mb-2">Welcome to your Portal!</h2>
                <p class="text-gray-600 mb-8">Manage your registration, complete your payment, and submit your documents here.</p>

                <div class="bg-white p-6 rounded-2xl shadow-sm border mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg">Current Status</h3>
                        <span style="padding:0.25rem 0.75rem; background:var(--warning-bg); color:var(--warning-text); font-size:0.75rem; font-weight:bold; border-radius:9999px; text-transform:uppercase;">Payment Pending</span>
                    </div>

                    <div style="position:relative; padding-top:0.5rem;">
                        <div style="overflow:hidden; height:0.5rem; margin-bottom:1rem; display:flex; border-radius:0.25rem; background:var(--gray-100);">
                            <div style="width:25%; background:var(--primary);"></div>
                        </div>
                        <div class="flex justify-between" style="font-size:0.75rem; font-weight:500;">
                            <span class="text-primary font-bold">Registered</span>
                            <span class="text-gray-400 font-bold">Payment Pending</span>
                            <span class="text-gray-400">Not Submitted</span>
                            <span class="text-gray-400">Under Review</span>
                        </div>
                    </div>

                    <div style="margin-top:2rem; background:var(--info-bg); border:1px solid var(--info-border); border-radius:0.75rem; padding:1rem; display:flex;">
                        <i data-lucide="clock" style="color:var(--info-text); margin-right:0.75rem; flex-shrink:0;"></i>
                        <div>
                            <h4 style="font-size:0.875rem; color:var(--info-text); margin-bottom:0.25rem;">Action Required</h4>
                            <p style="font-size:0.875rem; color:var(--info-text); opacity:0.9;">You haven't completed your registration fee payment. Please proceed to the <button onclick="switchDashboardTab('payment')" style="text-decoration:underline; font-weight:bold; color:inherit;">Payment Info</button> tab to secure your spot.</p>
                        </div>
                    </div>
                </div>

                <div class="grid md-grid-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border">
                        <h3 class="text-lg mb-4" style="border-bottom:1px solid var(--gray-200); padding-bottom:0.5rem;">Profile Information</h3>
                        <ul style="display:flex; flex-direction:column; gap:0.75rem; font-size:0.875rem;">
                            <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Full Name</span> <span class="font-bold">Dr. Jane Doe, M.Sc.</span></li>
                            <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Email</span> <span class="font-bold">jane.doe@university.edu</span></li>
                            <li class="flex flex-col"><span class="text-gray-500" style="font-size:0.75rem;">Phone</span> <span class="font-bold">+62 812-3456-7890</span></li>
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
                        <h3 class="text-lg mb-6">Upload Proof of Payment</h3>
                        <form onsubmit="event.preventDefault(); alert('Payment proof submitted for verification!'); switchDashboardTab('overview');">
                            <div class="form-group">
                                <label class="form-label">Sender's Bank Name</label>
                                <input type="text" required class="form-control" placeholder="e.g. Bank Central Asia (BCA)" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sender's Account Name</label>
                                <input type="text" required class="form-control" placeholder="e.g. Jane Doe" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Upload Receipt (JPG/PNG/PDF)</label>
                                <div style="border:2px dashed var(--gray-300); border-radius:0.75rem; padding:1.5rem; text-align:center; background:var(--gray-50); cursor:pointer;">
                                    <i data-lucide="upload" class="text-gray-400" style="width:2rem; height:2rem; margin:0 auto 0.5rem;"></i>
                                    <p class="text-sm font-bold text-gray-600">Click to select file</p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-gradient w-full">Submit Payment Proof</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab: Submission -->
            <div id="dash-tab-submission" class="dash-content">
                <h2 class="text-2xl mb-6">My Submission</h2>
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                    <div class="p-8">
                        <form onsubmit="event.preventDefault(); alert('Document submitted successfully!'); switchDashboardTab('overview');">

                            <div class="form-group">
                                <label class="form-label">Institutional Affiliation <span class="text-primary">*</span></label>
                                <input type="text" required class="form-control" placeholder="e.g. Poltekkes Kemenkes Jakarta III" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Country <span class="text-primary">*</span></label>
                                <select onchange="handleCountryChange(this)" required class="form-control">
                                    <option value="" disabled selected>Select your country...</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Japan">Japan</option>
                                    <option value="India">India</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div id="other-country-container" class="form-group hidden animate-fadeIn">
                                <label class="form-label">Please specify your country <span class="text-primary">*</span></label>
                                <input type="text" id="other-country-input" class="form-control" placeholder="Enter your country name" />
                            </div>

                            <div class="form-group" style="padding-top:1.5rem; border-top:1px solid var(--gray-100); margin-top:1.5rem;">
                                <label class="form-label mb-4">Select Competition Category <span class="text-primary">*</span></label>
                                <div class="grid md-grid-2" style="gap:1rem;">
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="IRPC" required />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">IRPC</span>
                                            <span class="text-xs text-gray-500 mt-1">International Research Pitch</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="BPPA" required />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">BPPA</span>
                                            <span class="text-xs text-gray-500 mt-1">Best Published Paper</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="AHIC" required />
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">AHIC</span>
                                            <span class="text-xs text-gray-500 mt-1">Innovation Challenge</span>
                                        </div>
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </label>
                                    <label class="radio-card">
                                        <input type="radio" name="category" value="E2IPBC" required />
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
                                <input type="text" required class="form-control" placeholder="Enter your research/innovation title" />
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
                                    <input type="url" required class="form-control" style="padding-left:2.5rem;" placeholder="https://drive.google.com/drive/folders/..." />
                                </div>
                            </div>

                            <div class="flex justify-end mt-8">
                                <button type="submit" class="btn btn-gradient text-lg">Save & Submit Document</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab: Settings -->
            <div id="dash-tab-settings" class="dash-content">
                <h2 class="text-2xl mb-6">Account Settings</h2>
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="max-width:32rem;">
                    <div class="p-8">
                        <h3 class="text-lg mb-6 flex items-center"><i data-lucide="key-round" class="text-primary mr-2"></i> Update Password</h3>
                        <form onsubmit="event.preventDefault(); alert('Password updated successfully!');">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="password" required class="form-control" placeholder="••••••••" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" required class="form-control" placeholder="••••••••" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" required class="form-control" placeholder="••••••••" />
                            </div>
                            <button type="submit" class="btn btn-dark w-full mt-4 text-lg">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>