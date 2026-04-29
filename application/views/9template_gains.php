<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAINS 2026 | Poltekkes Kemenkes Jakarta III</title>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom CSS5 (Modern CSS) -->
    <style>
        /* === CSS Variables & Theming === */
        :root {
            --primary: #00A599;
            --primary-dark: #008c82;
            --primary-light: rgba(0, 165, 153, 0.1);
            --secondary: #7DC789;
            --secondary-light: rgba(125, 199, 137, 0.2);
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --warning-bg: #fef9c3;
            --warning-text: #a16207;
            --info-bg: #eff6ff;
            --info-text: #1e3a8a;
            --info-border: #dbeafe;
        }

        /* === Reset & Base Styles === */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--gray-900);
            background: var(--white);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.5;
        }

        a,
        button {
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: inherit;
        }

        h1,
        h2,
        h3,
        h4 {
            font-weight: 700;
            line-height: 1.2;
            color: var(--gray-900);
        }

        ul {
            list-style: none;
        }

        input,
        select {
            font-family: inherit;
        }

        /* === Typography Utilities === */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-primary {
            color: var(--primary);
        }

        .text-secondary {
            color: var(--secondary);
        }

        .text-gray-500 {
            color: var(--gray-500);
        }

        .text-gray-600 {
            color: var(--gray-600);
        }

        .font-bold {
            font-weight: 700;
        }

        .font-extrabold {
            font-weight: 800;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .text-3xl {
            font-size: 1.875rem;
        }

        .text-4xl {
            font-size: 2.25rem;
        }

        .text-gradient {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        /* === Layout Utilities === */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .container-sm {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .items-start {
            align-items: flex-start;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-center {
            justify-content: center;
        }

        .grid {
            display: grid;
            gap: 2rem;
        }

        .hidden {
            display: none !important;
        }

        .w-full {
            width: 100%;
        }

        /* Spacing */
        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .mb-12 {
            margin-bottom: 3rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .p-8 {
            padding: 2rem;
        }

        /* Backgrounds & Borders */
        .bg-gray-50 {
            background-color: var(--gray-50);
        }

        .bg-white {
            background-color: var(--white);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .border {
            border: 1px solid var(--gray-200);
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* === Animations === */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }

        /* === Components === */

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 9999px;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 165, 153, 0.3);
        }

        .btn-outline {
            border: 2px solid rgba(0, 165, 153, 0.2);
            color: var(--primary);
            border-radius: 9999px;
            background: white;
        }

        .btn-outline:hover {
            border-color: var(--primary);
        }

        .btn-dark {
            background: var(--gray-900);
            color: white;
        }

        .btn-dark:hover {
            background: var(--gray-800);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            outline: none;
            transition: all 0.2s;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Custom Radio Card */
        .radio-card {
            display: flex;
            cursor: pointer;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            padding: 1rem;
            background: white;
            transition: all 0.2s;
            position: relative;
        }

        .radio-card:hover {
            border-color: var(--primary);
        }

        .radio-card input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .radio-card input[type="radio"]:checked+.radio-content {
            border-color: var(--primary);
            box-shadow: 0 0 0 1px var(--primary);
        }

        .radio-card .check-icon {
            display: none;
            color: var(--primary);
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .radio-card input[type="radio"]:checked~.check-icon {
            display: block;
        }

        /* Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .nav-inner {
            display: flex;
            justify-content: space-between;
            height: 5rem;
            align-items: center;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            margin-right: 0.75rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 0.75rem;
            color: var(--gray-600);
            font-weight: 500;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--gray-50);
        }

        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
        }

        /* Dropdown */
        .dropdown {
            position: relative;
            padding: 0.5rem 0;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 16rem;
            background: white;
            border: 1px solid var(--gray-100);
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-sub-link {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.5rem 1rem;
            color: var(--gray-700);
            font-size: 0.875rem;
        }

        .nav-sub-link:hover {
            background: var(--gray-50);
            color: var(--primary);
        }

        .nav-sub-link.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
        }

        /* Specific Sections */
        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .hero {
            position: relative;
            overflow: hidden;
            background: var(--gray-50);
            padding: 6rem 0;
        }

        .hero-bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
        }

        .hero-shape-1 {
            top: -6rem;
            right: -6rem;
            width: 24rem;
            height: 24rem;
            background: rgba(125, 199, 137, 0.2);
        }

        .hero-shape-2 {
            top: 50%;
            left: -6rem;
            width: 18rem;
            height: 18rem;
            background: rgba(0, 165, 153, 0.2);
        }

        .hero-content {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .hero-text {
            flex: 3;
        }

        .hero-card {
            flex: 2;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .timeline-list {
            position: relative;
            border-left: 4px solid var(--secondary);
            margin-left: 1.5rem;
            padding-bottom: 2rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 3rem;
        }

        .timeline-dot {
            position: absolute;
            left: -0.6rem;
            top: 0;
            width: 1rem;
            height: 1rem;
            background: white;
            border: 4px solid var(--primary);
            border-radius: 50%;
            transition: all 0.3s;
        }

        .timeline-item:hover .timeline-dot {
            transform: scale(1.25);
            background: var(--primary);
        }

        .timeline-card {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--gray-100);
            transition: box-shadow 0.3s;
        }

        .timeline-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .auth-card {
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--gray-100);
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 2rem;
            text-align: center;
            color: white;
        }

        /* Dashboard Layout */
        .dashboard-layout {
            display: flex;
            flex-direction: column;
            min-height: 80vh;
            background: var(--gray-50);
        }

        .dash-sidebar {
            background: white;
            border-right: 1px solid var(--gray-200);
            padding: 1.5rem;
            flex-shrink: 0;
        }

        .dash-main {
            flex-grow: 1;
            padding: 1.5rem;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        .dash-tab-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
            text-align: left;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .dash-tab-btn:hover {
            background: var(--gray-100);
        }

        .dash-tab-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 165, 153, 0.2);
        }

        .dash-tab-btn.active svg {
            color: white;
        }

        .dash-content {
            display: none;
        }

        .dash-content.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        /* Grid Breakpoints */
        @media (min-width: 768px) {
            .md-grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }

            .md-grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }

            .dashboard-layout {
                flex-direction: row;
            }

            .dash-sidebar {
                width: 260px;
                min-height: 80vh;
            }

            .dash-main {
                padding: 2.5rem;
            }
        }

        @media (min-width: 1024px) {
            .lg-grid-4 {
                grid-template-columns: repeat(4, 1fr);
            }

            .lg-grid-12 {
                grid-template-columns: repeat(12, 1fr);
            }

            .lg-col-4 {
                grid-column: span 4 / span 4;
            }

            .lg-col-8 {
                grid-column: span 8 / span 8;
            }
        }

        @media (max-width: 1023px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-actions {
                justify-content: center;
            }

            .desktop-only {
                display: none !important;
            }
        }

        /* Footer */
        .footer {
            background: var(--gray-900);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: auto;
        }

        .footer a {
            color: var(--gray-400);
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--secondary);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-inner">
                <!-- Logo -->
                <div class="nav-brand" onclick="navigateTo('home')">
                    <div class="nav-logo-icon">
                        <i data-lucide="shield-plus"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold text-primary" style="line-height: 1;">GAINS 2026</span>
                        <span class="text-xs font-bold text-secondary" style="font-size: 0.65rem; letter-spacing: 0.05em;">POLTEKKES JAKARTA III</span>
                    </div>
                </div>

                <!-- Desktop NavLinks -->
                <div class="nav-menu desktop-only">
                    <button class="nav-link active" data-target="home" onclick="navigateTo('home')">
                        <i data-lucide="home" style="width: 1rem; height: 1rem;"></i> Home
                    </button>
                    <button class="nav-link" data-target="about" onclick="navigateTo('about')">
                        <i data-lucide="info" style="width: 1rem; height: 1rem;"></i> About GAINS
                    </button>

                    <!-- Competitions Dropdown -->
                    <div class="dropdown">
                        <button class="nav-link" data-target="comp">
                            <i data-lucide="award" style="width: 1rem; height: 1rem;"></i> Competitions <i data-lucide="chevron-down" style="width: 0.8rem; height: 0.8rem;"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="nav-sub-link" data-target="comp-irpc" onclick="navigateTo('comp-irpc')">International Pitch (IRPC)</button>
                            <button class="nav-sub-link" data-target="comp-bppa" onclick="navigateTo('comp-bppa')">Best Published Paper (BPPA)</button>
                            <button class="nav-sub-link" data-target="comp-ahic" onclick="navigateTo('comp-ahic')">Innovation Challenge (AHIC)</button>
                            <button class="nav-sub-link" data-target="comp-e2ipbc" onclick="navigateTo('comp-e2ipbc')">Policy Brief (E2I-PBC)</button>
                        </div>
                    </div>

                    <button class="nav-link" data-target="timeline" onclick="navigateTo('timeline')">
                        <i data-lucide="calendar" style="width: 1rem; height: 1rem;"></i> Timeline
                    </button>
                    <button class="nav-link" data-target="reviewers" onclick="navigateTo('reviewers')">
                        <i data-lucide="users" style="width: 1rem; height: 1rem;"></i> Reviewers
                    </button>

                    <!-- Auth Buttons (Dynamic) -->
                    <div id="nav-auth-buttons" style="margin-left: 1rem;">
                        <button onclick="navigateTo('auth')" class="btn btn-gradient" style="padding: 0.5rem 1.5rem;">
                            Portal Login
                        </button>
                    </div>

                    <div id="nav-user-buttons" class="hidden items-center" style="margin-left: 1rem; gap: 0.5rem;">
                        <button onclick="navigateTo('dashboard')" class="btn btn-dark" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i data-lucide="layout-dashboard" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i> Dashboard
                        </button>
                        <button onclick="handleLogout()" style="padding: 0.5rem; color: var(--gray-500); border-radius: 50%;" title="Logout" onmouseover="this.style.color='var(--danger)'; this.style.backgroundColor='var(--danger-light)'" onmouseout="this.style.color='var(--gray-500)'; this.style.backgroundColor='transparent'">
                            <i data-lucide="log-out" style="width: 1.25rem; height: 1.25rem;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-grow">

        <!-- PAGE: HOME -->
        <div id="page-home" class="page-section active">
            <!-- Hero Section -->
            <div class="hero">
                <div class="hero-bg-shape hero-shape-1"></div>
                <div class="hero-bg-shape hero-shape-2"></div>

                <div class="container hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">
                            <span class="text-gradient">Global Academic Innovation Series (GAINS)</span> 2026
                        </h1>
                        <p class="hero-subtitle">
                            Join the International Research & Innovation Competition for Lecturers and Researchers 2026. Transforming applied research into tangible impacts for healthcare practice, public policy, and community empowerment.
                        </p>
                        <div class="hero-actions">
                            <button id="hero-cta-btn" onclick="navigateTo('auth')" class="btn btn-gradient text-lg">
                                Register / Login
                            </button>
                            <button onclick="navigateTo('about')" class="btn btn-outline text-lg">
                                Find More
                            </button>
                        </div>
                    </div>

                    <div class="hero-card">
                        <h3 class="text-2xl font-bold mb-6 flex items-center">
                            <i data-lucide="calendar" class="text-primary mr-2"></i> Important Dates
                        </h3>
                        <ul style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <li class="flex items-start">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: var(--primary); box-shadow: 0 0 0 4px var(--primary-light); margin-top: 6px; margin-right: 1rem; flex-shrink: 0;"></div>
                                <div>
                                    <p class="text-sm font-bold text-primary">May 2026</p>
                                    <p class="font-bold">Launching GAINS (Dies Natalis 25 Years)</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: var(--gray-300); margin-top: 6px; margin-right: 1rem; flex-shrink: 0;"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-500">May - Jun 2026</p>
                                    <p class="font-bold">Call for Abstract & Submission</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: var(--gray-300); margin-top: 6px; margin-right: 1rem; flex-shrink: 0;"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-500">Jun - Jul 2026</p>
                                    <p class="font-bold">Scientific Review Process</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: var(--gray-300); margin-top: 6px; margin-right: 1rem; flex-shrink: 0;"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-500">15-16 Sep 2026</p>
                                    <p class="font-bold">Conference & Final GAINS</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Program Outputs -->
            <div class="py-16 bg-white">
                <div class="container text-center">
                    <h2 class="text-3xl mb-12">Expected Outputs & Benefits</h2>
                    <div class="grid md-grid-2 lg-grid-4">
                        <div class="border rounded-xl p-6 transition" onmouseover="this.style.borderColor='var(--secondary)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            <div style="width: 3.5rem; height: 3.5rem; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i data-lucide="award" class="text-primary"></i>
                            </div>
                            <h3 class="text-xl mb-2">Awards & Recognition</h3>
                            <p class="text-gray-600">Winner, Runner-up, and Special Mention accolades.</p>
                        </div>
                        <div class="border rounded-xl p-6 transition" onmouseover="this.style.borderColor='var(--secondary)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            <div style="width: 3.5rem; height: 3.5rem; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i data-lucide="book-open" class="text-primary"></i>
                            </div>
                            <h3 class="text-xl mb-2">Publications</h3>
                            <p class="text-gray-600">Book of Abstracts and/or Conference Proceedings.</p>
                        </div>
                        <div class="border rounded-xl p-6 transition" onmouseover="this.style.borderColor='var(--secondary)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            <div style="width: 3.5rem; height: 3.5rem; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i data-lucide="globe" class="text-primary"></i>
                            </div>
                            <h3 class="text-xl mb-2">Global Networking</h3>
                            <p class="text-gray-600">International academic collaboration opportunities.</p>
                        </div>
                        <div class="border rounded-xl p-6 transition" onmouseover="this.style.borderColor='var(--secondary)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            <div style="width: 3.5rem; height: 3.5rem; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i data-lucide="check-circle" class="text-primary"></i>
                            </div>
                            <h3 class="text-xl mb-2">Certification</h3>
                            <p class="text-gray-600">Internationally recognized certificates for participants.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: ABOUT -->
        <div id="page-about" class="page-section bg-gray-50">
            <div class="container">
                <div class="text-center mb-12">
                    <h1 class="text-4xl mb-4">About GAINS</h1>
                    <p class="text-lg text-gray-600">Discover the vision, mission, and objectives behind the Global Academic Innovation Series.</p>
                </div>

                <div class="grid lg-grid-12 items-start">
                    <div class="lg-col-4">
                        <div class="bg-white rounded-2xl shadow-lg border p-6 text-center" style="position: sticky; top: 6rem; min-height: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <div style="border: 2px dashed var(--gray-300); width: 100%; height: 100%; border-radius: 1rem; padding: 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <i data-lucide="image" class="text-gray-300 mb-4" style="width: 4rem; height: 4rem;"></i>
                                <h3 class="text-xl text-gray-500 mb-2">Event Poster</h3>
                                <p class="text-sm text-gray-400">Portrait Area (A4 or 4:5 ratio)</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg-col-8">
                        <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">
                            <div class="flex items-center mb-6">
                                <div style="background: var(--primary-light); padding: 0.75rem; border-radius: 0.5rem; margin-right: 1rem;"><i data-lucide="globe" class="text-primary" style="width: 2rem; height: 2rem;"></i></div>
                                <h2 class="text-3xl">Background</h2>
                            </div>
                            <div class="text-gray-600 text-lg" style="display: flex; flex-direction: column; gap: 1rem;">
                                <p>The advancement of science and technology in the health sector, along with the dynamics of global challenges, requires lecturers and researchers not only to produce academically rigorous research but also to develop innovations that have tangible impacts on healthcare practices, public policy, and community empowerment.</p>
                                <p>In the current global context, cross-country collaboration has become a crucial strategy to enhance research quality, broaden knowledge exchange, and generate health solutions that are adaptable to diverse settings, particularly in <span class="font-bold text-primary">Low- and Middle-Income Countries (LMICs)</span>.</p>
                                <p>As a vocational higher education institution in health under the Ministry of Health of the Republic of Indonesia, Poltekkes Kemenkes Jakarta III is committed to strengthening an academic culture that is excellent, innovative, and globally competitive. This commitment is realized through the enhancement of applied research, evidence-based innovation, and the development of sustainable international academic networks.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm border p-8">
                            <div class="flex items-center mb-6">
                                <div style="background: var(--secondary-light); padding: 0.75rem; border-radius: 0.5rem; margin-right: 1rem;"><i data-lucide="lightbulb" class="text-primary" style="width: 2rem; height: 2rem;"></i></div>
                                <h2 class="text-3xl">Objectives</h2>
                            </div>
                            <p class="text-gray-600 text-lg mb-6">GAINS serves as a strategic platform for strengthening the role of lecturers and researchers. Through this initiative, we aim to achieve the following:</p>
                            <ul style="display: flex; flex-direction: column; gap: 1rem;">
                                <li class="bg-gray-50 p-4 rounded-xl border flex items-start">
                                    <i data-lucide="check-circle" class="text-secondary mr-2" style="flex-shrink: 0; margin-top: 2px;"></i>
                                    <span class="text-gray-700 text-lg">Generate high-quality, collaborative, and impactful research and innovation contributing to healthcare practice, education, and health policy.</span>
                                </li>
                                <li class="bg-gray-50 p-4 rounded-xl border flex items-start">
                                    <i data-lucide="check-circle" class="text-secondary mr-2" style="flex-shrink: 0; margin-top: 2px;"></i>
                                    <span class="text-gray-700 text-lg">Establish a sustainable international academic network to enhance cross-country collaboration.</span>
                                </li>
                                <li class="bg-gray-50 p-4 rounded-xl border flex items-start">
                                    <i data-lucide="check-circle" class="text-secondary mr-2" style="flex-shrink: 0; margin-top: 2px;"></i>
                                    <span class="text-gray-700 text-lg">Enhance capacities in developing evidence-based research and innovations responsive to societal needs, especially within LMICs.</span>
                                </li>
                                <li class="bg-gray-50 p-4 rounded-xl border flex items-start">
                                    <i data-lucide="check-circle" class="text-secondary mr-2" style="flex-shrink: 0; margin-top: 2px;"></i>
                                    <span class="text-gray-700 text-lg">Reinforce the role of Poltekkes Kemenkes Jakarta III as an institution actively contributing to global science and health innovation.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: TIMELINE -->
        <div id="page-timeline" class="page-section bg-white">
            <div class="container-sm">
                <div class="text-center mb-12">
                    <h1 class="text-4xl mb-4">Timeline & Important Dates</h1>
                    <p class="text-lg text-gray-600">Mark your calendar for these crucial GAINS 2026 milestones.</p>
                </div>

                <div class="timeline-list">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: var(--secondary-light); color: var(--primary); font-weight: bold; font-size: 0.875rem; margin-bottom: 0.75rem;">May 2026</span>
                            <h3 class="text-xl flex items-center mb-2"><i data-lucide="globe" class="text-primary mr-2" style="width: 1.25rem;"></i> Launching GAINS</h3>
                            <p class="text-gray-600">Official launch event coinciding with the 25th Dies Natalis of Poltekkes Kemenkes Jakarta III.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: var(--secondary-light); color: var(--primary); font-weight: bold; font-size: 0.875rem; margin-bottom: 0.75rem;">May – June 2026</span>
                            <h3 class="text-xl flex items-center mb-2"><i data-lucide="upload" class="text-primary mr-2" style="width: 1.25rem;"></i> Call for Abstract & Submission</h3>
                            <p class="text-gray-600">Open for oral & poster submissions across all four competition categories.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: var(--secondary-light); color: var(--primary); font-weight: bold; font-size: 0.875rem; margin-bottom: 0.75rem;">June – July 2026</span>
                            <h3 class="text-xl flex items-center mb-2"><i data-lucide="users" class="text-primary mr-2" style="width: 1.25rem;"></i> Scientific Review Process</h3>
                            <p class="text-gray-600">Comprehensive evaluation by our national and international reviewer panel based on standardized rubrics.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: var(--secondary-light); color: var(--primary); font-weight: bold; font-size: 0.875rem; margin-bottom: 0.75rem;">August 2026</span>
                            <h3 class="text-xl flex items-center mb-2"><i data-lucide="check-circle" class="text-primary mr-2" style="width: 1.25rem;"></i> Acceptance Notification</h3>
                            <p class="text-gray-600">Announcement of shortlisted candidates who will proceed to the final presentation/exhibition stage.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: var(--secondary-light); color: var(--primary); font-weight: bold; font-size: 0.875rem; margin-bottom: 0.75rem;">15-16 September 2026</span>
                            <h3 class="text-xl flex items-center mb-2"><i data-lucide="award" class="text-primary mr-2" style="width: 1.25rem;"></i> Conference & Final GAINS</h3>
                            <p class="text-gray-600">The main hybrid event featuring live pitches, exhibitions, and the awarding ceremony.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: REVIEWERS -->
        <div id="page-reviewers" class="page-section bg-gray-50">
            <div class="container">
                <div class="text-center mb-12">
                    <h1 class="text-4xl mb-4">Board of Reviewers</h1>
                    <p class="text-lg text-gray-600 container-sm" style="padding:0">Our esteemed panel consists of international adjudicators, national academic experts, and industry practitioners ensuring a rigorous and globally benchmarked evaluation process.</p>
                </div>

                <div style="display:flex; flex-direction:column; gap:3rem;">
                    <!-- IRPC -->
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                        <div class="p-6 border" style="border-width:0 0 1px 0; background: var(--primary-light); display:flex; align-items:center;">
                            <i data-lucide="users" class="text-primary mr-2"></i>
                            <h3 class="text-xl">International Research Pitch Competition (IRPC)</h3>
                        </div>
                        <div class="p-6 grid md-grid-3">
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">International Reviewer</h4>
                                <p class="text-sm text-gray-700">Professor / Associate Professor from The University of Osaka (Japan) or Charles Darwin University</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 1</h4>
                                <p class="text-sm text-gray-700">Senior scholar in health research disciplines</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 2</h4>
                                <p class="text-sm text-gray-700">Senior academic in health education</p>
                            </div>
                        </div>
                    </div>

                    <!-- BPPA -->
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                        <div class="p-6 border" style="border-width:0 0 1px 0; background: var(--secondary-light); display:flex; align-items:center;">
                            <i data-lucide="users" class="text-secondary mr-2"></i>
                            <h3 class="text-xl">Best Published Paper Award (BPPA)</h3>
                        </div>
                        <div class="p-6 grid md-grid-3">
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">International Reviewer</h4>
                                <p class="text-sm text-gray-700">Senior academic / international peer-reviewer from German institutional partner</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 1</h4>
                                <p class="text-sm text-gray-700">Editor of nationally indexed scholarly journals</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 2</h4>
                                <p class="text-sm text-gray-700">Senior academic in health sciences</p>
                            </div>
                        </div>
                    </div>

                    <!-- AHIC -->
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                        <div class="p-6 border" style="border-width:0 0 1px 0; background: var(--primary-light); display:flex; align-items:center;">
                            <i data-lucide="users" class="text-primary mr-2"></i>
                            <h3 class="text-xl">Academic & Health Innovation Challenge (AHIC)</h3>
                        </div>
                        <div class="p-6 grid md-grid-3">
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">International Reviewer</h4>
                                <p class="text-sm text-gray-700">Health innovation academic/practitioner from Malaysian institutional partner</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 1</h4>
                                <p class="text-sm text-gray-700">Health innovation practitioner</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 2</h4>
                                <p class="text-sm text-gray-700">Vocational health education academic</p>
                            </div>
                        </div>
                    </div>

                    <!-- E2IPBC -->
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                        <div class="p-6 border" style="border-width:0 0 1px 0; background: var(--secondary-light); display:flex; align-items:center;">
                            <i data-lucide="users" class="text-secondary mr-2"></i>
                            <h3 class="text-xl">Evidence-to-Impact Policy Brief Competition (E2I-PBC)</h3>
                        </div>
                        <div class="p-6 grid md-grid-3">
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">International Reviewer</h4>
                                <p class="text-sm text-gray-700">Health systems researcher / policy expert from Indian institutional partner</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 1</h4>
                                <p class="text-sm text-gray-700">Indonesian health policy expert (Ministry of Health / regulatory body)</p>
                            </div>
                            <div class="bg-gray-50 p-4 border rounded-lg">
                                <div style="width:3rem; height:3rem; background:var(--gray-200); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;"><i data-lucide="user-plus" class="text-gray-500"></i></div>
                                <h4 class="text-sm text-primary mb-1">National Reviewer 2</h4>
                                <p class="text-sm text-gray-700">Public health academic expert</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: COMPETITION (Dynamic Container) -->
        <div id="page-competition" class="page-section bg-white">
            <div class="container" id="competition-content" style="max-width:1000px;">
                <!-- Injected via JS -->
            </div>
        </div>

        <!-- PAGE: AUTH -->
        <div id="page-auth" class="page-section bg-gray-50" style="padding-top:6rem; padding-bottom:6rem;">
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
                        <form onsubmit="handleLogin(event)">
                            <div id="auth-name-field" class="form-group hidden">
                                <label class="form-label">Full Name (with Titles)</label>
                                <input type="text" id="auth-name-input" class="form-control" placeholder="Dr. Jane Doe, M.Sc." />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" required class="form-control" placeholder="jane.doe@university.edu" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" required class="form-control" placeholder="••••••••" />
                            </div>

                            <button type="submit" id="auth-submit-btn" class="btn btn-gradient w-full mt-4 text-lg">
                                Log In to Dashboard
                            </button>
                        </form>

                        <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--gray-100); text-align:center;">
                            <p class="text-sm text-gray-600">
                                <span id="auth-switch-text">Don't have an account? </span>
                                <button onclick="toggleAuthMode()" id="auth-switch-btn" class="font-bold text-primary" style="text-decoration:underline;">
                                    Register here
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: DASHBOARD -->
        <div id="page-dashboard" class="page-section" style="padding:0;">
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

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="grid md-grid-3">
                <div>
                    <h3 class="text-2xl text-secondary mb-4">GAINS 2026</h3>
                    <p class="text-gray-400 text-sm mb-4">
                        Global Academic Innovation Series (GAINS) I 2026.<br />
                        International Research & Innovation Competition for Lecturers and Researchers.
                    </p>
                    <p class="text-gray-400 text-sm font-bold">Organized by Poltekkes Kemenkes Jakarta III</p>
                </div>
                <div>
                    <h4 class="text-lg mb-4" style="border-bottom:2px solid var(--primary); padding-bottom:0.5rem; display:inline-block; color:white;">Quick Links</h4>
                    <ul style="display:flex; flex-direction:column; gap:0.5rem; font-size:0.875rem;">
                        <li><a href="#" onclick="event.preventDefault(); navigateTo('about')">About GAINS</a></li>
                        <li><a href="#" onclick="event.preventDefault(); navigateTo('timeline')">Important Dates</a></li>
                        <li><a href="#" onclick="event.preventDefault(); navigateTo('auth')">Register / Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg mb-4" style="border-bottom:2px solid var(--primary); padding-bottom:0.5rem; display:inline-block; color:white;">Contact Us</h4>
                    <ul style="display:flex; flex-direction:column; gap:0.75rem; font-size:0.875rem; color:var(--gray-400);">
                        <li class="flex items-start"><i data-lucide="map-pin" class="text-secondary mr-2" style="flex-shrink:0;"></i> Jl. Arteri JORR Jatiwarna, Bekasi, West Java, Indonesia</li>
                        <li class="flex items-center"><i data-lucide="mail" class="text-secondary mr-2" style="flex-shrink:0;"></i> gains2026@poltekkesjakarta3.ac.id</li>
                        <li class="flex items-center"><i data-lucide="phone" class="text-secondary mr-2" style="flex-shrink:0;"></i> +62 812-3456-7890 (Information Desk)</li>
                    </ul>
                </div>
            </div>
            <div style="margin-top:3rem; padding-top:2rem; border-top:1px solid var(--gray-800); text-align:center; font-size:0.875rem; color:var(--gray-500);">
                &copy; <span id="current-year"></span> Poltekkes Kemenkes Jakarta III. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- JavaScript Application Logic -->
    <script>
        // Data for Competitions
        const competitionsData = {
            'comp-irpc': {
                title: "International Research Pitch Competition (IRPC)",
                icon: "lightbulb",
                format: "A concise presentation of a research proposal for an ongoing or planned study.",
                requirements: ["Submission of an extended abstract (maximum 1,500 words).", "Live pitch presentation lasting strictly 5–7 minutes.", "Must clearly highlight the research problem, methodology, and expected impact on healthcare."],
                appeal: ["Favored by early-career and mid-career researchers.", "Reflects the format of international grant pitching schemes.", "Fast-paced, competitive, and interactive."],
                color: "var(--primary)",
                details: "The IRPC provides a dynamic platform for researchers to pitch their innovative ideas clearly and persuasively. It is designed to evaluate not only the scientific merit of the proposed or ongoing research but also the researcher's ability to communicate complex concepts effectively to a broader audience."
            },
            'comp-bppa': {
                title: "Best Published Paper Award (BPPA)",
                icon: "book-open",
                format: "Recognition of scientific articles published in reputable journals (within the last three years). The assessment will consider whether the research: \n• Demonstrates a measurable impact on professional practice \n• Informs or contributes to policy development \n• Is integrated into educational contexts \n• Exhibits relevance across diverse international settings",
                requirements: ["Submission of the full PDF file of the published article.", "An impact statement (maximum 500 words) detailing the paper's contribution to the field.", "Proof of journal indexing and reputation (e.g., Scopus, Web of Science)."],
                appeal: ["Characterized by strong academic prestige and scholarly rigor.", "Appeals to senior and internationally engaged researchers.", "Does not necessitate the undertaking of new primary research."],
                color: "var(--secondary)",
                details: "This award honors outstanding publications that have demonstrated significant impact in their respective fields. Submissions will be evaluated based on originality, methodology rigor, citation impact, and relevance to solving pressing global health challenges."
            },
            'comp-ahic': {
                title: "Academic & Health Innovation Challenge (AHIC)",
                icon: "award",
                format: "A research-based innovation competition in the fields of health, health education, or community services. \n• Innovations grounded in robust scientific evidence (evidence-based) \n• Relevant to real-world needs, particularly within the context of Low- and Middle-Income Countries (LMICs) \n• Demonstrates strong potential for implementation, scalability, and further development",
                requirements: ["Detailed innovation description document (maximum 2,000 words).", "Submission of supporting evidence, such as pilot results, prototypes, or demonstration videos.", "The innovation product must be exhibited during the competition."],
                appeal: ["Highly applicable and contextually grounded.", "Attracts participants from diverse disciplinary backgrounds.", "Particularly relevant to developing countries and Low- and Middle-Income Countries (LMICs)."],
                color: "var(--primary)",
                details: "AHIC focuses on practical innovations that can be implemented directly in healthcare or educational settings. We are actively looking for prototypes, digital health solutions, or new educational frameworks that directly address pressing community health needs."
            },
            'comp-e2ipbc': {
                title: "Evidence-to-Impact Policy Brief Competition (E2I-PBC)",
                icon: "file-text",
                format: "A competition focused on the development of evidence-informed policy briefs grounded in research findings.",
                requirements: ["Submission of a structured policy brief (2–4 pages).", "Must be developed in accordance with standard academic and policy-making guidelines.", "A clearly articulated description of the intended policy audience (e.g., governmental bodies, institutional stakeholders, or international organizations)."],
                appeal: ["Exhibits strong global relevance and contextual applicability across diverse settings.", "Effectively facilitates the translation of research evidence into policy formulation and decision-making processes.", "Serves as a strategic instrument for strengthening institutional positioning and engagement with regulatory and policymaking bodies."],
                color: "var(--secondary)",
                details: "This competition challenges academics to bridge the critical gap between research and policy. Participants must distill complex research findings into clear, concise, and actionable policy recommendations aimed specifically at decision-makers and government bodies."
            }
        };

        // State
        let currentPage = 'home';
        let isLoggedIn = false;
        let authMode = 'login';
        let dashboardTab = 'overview';

        // Initialize
        document.getElementById('current-year').textContent = new Date().getFullYear();
        lucide.createIcons();

        // Navigation Handler
        function navigateTo(pageId) {
            currentPage = pageId;

            // Handle protection for dashboard
            if (pageId === 'dashboard' && !isLoggedIn) {
                pageId = 'auth';
            }

            // Hide all pages
            document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));

            // Check if it's a competition page
            if (pageId.startsWith('comp-')) {
                renderCompetitionPage(pageId);
                document.getElementById('page-competition').classList.add('active');
            } else {
                const targetPage = document.getElementById('page-' + pageId);
                if (targetPage) targetPage.classList.add('active');
            }

            updateNavStyles(pageId);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Update active states in Navbar
        function updateNavStyles(pageId) {
            document.querySelectorAll('.nav-link, .nav-sub-link').forEach(btn => {
                let target = btn.getAttribute('data-target');
                btn.classList.remove('active');

                // Set active style
                if (target === pageId || (pageId.startsWith('comp-') && target === 'comp')) {
                    btn.classList.add('active');
                }
            });
        }

        // Render dynamic competition page
        function renderCompetitionPage(type) {
            const comp = competitionsData[type];
            const contentDiv = document.getElementById('competition-content');

            let reqHtml = comp.requirements.map(req => `<li style="margin-bottom:0.5rem;">${req}</li>`).join('');
            let appealHtml = comp.appeal.map(item => `<li style="margin-bottom:0.5rem;">${item}</li>`).join('');

            contentDiv.innerHTML = `
                <div class="flex flex-col items-center text-center mb-12 animate-fadeIn">
                    <div style="background-color: ${comp.color === 'var(--primary)' ? 'var(--primary-light)' : 'var(--secondary-light)'}; color: ${comp.color}; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem;">
                        <i data-lucide="${comp.icon}" style="width: 3rem; height: 3rem;"></i>
                    </div>
                    <h1 class="text-4xl font-extrabold mb-6">${comp.title}</h1>
                </div>
                <div class="grid lg-grid-12">
                    <div class="lg-col-8">
                        <div class="mb-8">
                            <h3 class="text-2xl border mb-4" style="border-width:0 0 1px 0; padding-bottom:0.5rem;">Overview</h3>
                            <p class="text-gray-700 text-lg">${comp.details}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-2xl border shadow-sm">
                            <h3 class="text-2xl mb-6">Technical Details</h3>
                            <div style="display:flex; flex-direction:column; gap:1.5rem;">
                                <div>
                                    <span class="flex items-center text-sm font-bold text-primary mb-2" style="text-transform:uppercase;"><i data-lucide="file-text" style="width:1rem; margin-right:0.5rem;"></i> Format</span>
                                    <div class="bg-white p-4 rounded-lg border text-gray-800 font-bold" style="white-space:pre-line;">${comp.format}</div>
                                </div>
                                <div>
                                    <span class="flex items-center text-sm font-bold text-primary mb-2" style="text-transform:uppercase;"><i data-lucide="check-circle" style="width:1rem; margin-right:0.5rem;"></i> Submission Requirements</span>
                                    <ul class="bg-white p-4 rounded-lg border text-gray-700" style="list-style-type:disc; padding-left:2rem;">${reqHtml}</ul>
                                </div>
                                <div>
                                    <span class="flex items-center text-sm font-bold text-primary mb-2" style="text-transform:uppercase;"><i data-lucide="award" style="width:1rem; margin-right:0.5rem;"></i> Key Appeal</span>
                                    <ul class="bg-white p-4 rounded-lg border text-gray-700" style="list-style-type:disc; padding-left:2rem;">${appealHtml}</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg-col-4">
                        <div class="bg-gray-900 p-8 rounded-2xl text-white text-center shadow-lg" style="position:sticky; top:7rem;">
                            <i data-lucide="file-text" class="text-secondary mb-4" style="width:3rem; height:3rem; margin:0 auto 1rem;"></i>
                            <h3 class="text-xl mb-2">Participant Guidelines</h3>
                            <p class="text-gray-400 text-sm mb-6">Download the comprehensive rulebook covering all categories, general evaluation criteria, and formatting rules.</p>
                            <button class="btn btn-gradient w-full">
                                <i data-lucide="download" style="margin-right:0.5rem; width:1.25rem;"></i> Download Guideline
                            </button>
                        </div>
                    </div>
                </div>
            `;
            lucide.createIcons();
        }

        // Auth Logic
        function toggleAuthMode() {
            authMode = authMode === 'login' ? 'register' : 'login';

            const title = document.getElementById('auth-title');
            const icon = document.getElementById('auth-icon');
            const submitBtn = document.getElementById('auth-submit-btn');
            const switchText = document.getElementById('auth-switch-text');
            const switchBtn = document.getElementById('auth-switch-btn');
            const nameField = document.getElementById('auth-name-field');
            const nameInput = document.getElementById('auth-name-input');

            if (authMode === 'login') {
                title.innerText = 'Portal Login';
                icon.setAttribute('data-lucide', 'lock');
                submitBtn.innerText = 'Log In to Dashboard';
                switchText.innerText = "Don't have an account? ";
                switchBtn.innerText = 'Register here';
                nameField.classList.add('hidden');
                nameInput.required = false;
            } else {
                title.innerText = 'Create Account';
                icon.setAttribute('data-lucide', 'user-plus');
                submitBtn.innerText = 'Sign Up & Continue';
                switchText.innerText = 'Already have an account? ';
                switchBtn.innerText = 'Log in here';
                nameField.classList.remove('hidden');
                nameInput.required = true;
            }
            lucide.createIcons();
        }

        function handleLogin(e) {
            e.preventDefault();
            isLoggedIn = true;
            document.getElementById('nav-auth-buttons').classList.add('hidden');
            document.getElementById('nav-user-buttons').classList.remove('hidden');
            document.getElementById('nav-user-buttons').classList.add('flex');

            // Change hero button
            document.getElementById('hero-cta-btn').innerText = "Go to Dashboard";
            document.getElementById('hero-cta-btn').onclick = () => navigateTo('dashboard');

            navigateTo('dashboard');
        }

        function handleLogout() {
            isLoggedIn = false;
            document.getElementById('nav-auth-buttons').classList.remove('hidden');
            document.getElementById('nav-user-buttons').classList.add('hidden');
            document.getElementById('nav-user-buttons').classList.remove('flex');

            // Change hero button back
            document.getElementById('hero-cta-btn').innerText = "Register / Login";
            document.getElementById('hero-cta-btn').onclick = () => navigateTo('auth');

            navigateTo('home');
        }

        // Dashboard Logic
        function switchDashboardTab(tabId) {
            dashboardTab = tabId;

            // Hide all tab contents
            document.querySelectorAll('.dash-content').forEach(el => el.classList.remove('active'));
            document.getElementById('dash-tab-' + tabId).classList.add('active');

            // Reset all tab button styles
            document.querySelectorAll('.dash-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Set active tab button
            document.getElementById('tab-btn-' + tabId).classList.add('active');
        }

        // Form logic
        function handleCountryChange(selectEl) {
            const container = document.getElementById('other-country-container');
            const input = document.getElementById('other-country-input');
            if (selectEl.value === 'Other') {
                container.classList.remove('hidden');
                input.required = true;
            } else {
                container.classList.add('hidden');
                input.required = false;
            }
        }
    </script>
</body>

</html>