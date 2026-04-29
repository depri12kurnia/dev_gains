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