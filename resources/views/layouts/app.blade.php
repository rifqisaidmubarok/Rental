<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Rental Kendaraan')
    </title>

    <style>

        /* =========================================================
           GLOBAL
        ========================================================= */

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --purple: #7c3aed;
            --green: #10b981;
            --orange: #f59e0b;
            --red: #ef4444;

            --dark: #0f172a;
            --dark-2: #1e293b;

            --text: #172033;
            --muted: #64748b;

            --border: #e2e8f0;
            --background: #f1f5f9;

            --white: #ffffff;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }


        a {
            text-decoration: none;
        }


        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            position: fixed;

            left: 0;
            top: 0;

            width: 250px;
            height: 100vh;

            background:
                linear-gradient(
                    180deg,
                    #0f172a 0%,
                    #111827 55%,
                    #172554 100%
                );

            color: white;

            z-index: 1000;

            overflow-y: auto;

            box-shadow:
                5px 0 25px rgba(15, 23, 42, 0.10);
        }


        .sidebar::-webkit-scrollbar {
            width: 5px;
        }


        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }


        .sidebar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }


        /* =========================================================
           LOGO
        ========================================================= */

        .logo {
            height: 76px;

            display: flex;
            align-items: center;

            padding: 0 20px;

            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }


        .logo-icon {
            width: 42px;
            height: 42px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 11px;

            font-size: 20px;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, 0.25);
        }


        .logo-text {
            font-size: 16px;

            font-weight: 800;

            color: #ffffff;

            letter-spacing: -0.2px;
        }


        .logo-subtitle {
            font-size: 11px;

            color: #94a3b8;

            margin-top: 3px;
        }


        /* =========================================================
           MENU TITLE
        ========================================================= */

        .menu-title {
            padding: 22px 20px 8px;

            font-size: 10px;

            color: #64748b;

            text-transform: uppercase;

            letter-spacing: 1.2px;

            font-weight: 700;
        }


        /* =========================================================
           MENU
        ========================================================= */

        .menu {
            list-style: none;

            padding: 0 12px;

            margin: 0;
        }


        .menu li {
            margin-bottom: 4px;
        }


        .menu a {
            position: relative;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 11px 13px;

            color: #cbd5e1;

            border-radius: 10px;

            font-size: 13px;

            font-weight: 500;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                transform 0.2s ease;
        }


        .menu a:hover {
            background: rgba(255, 255, 255, 0.07);

            color: #ffffff;

            transform: translateX(2px);
        }


        .menu a.active {
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            color: #ffffff;

            font-weight: 700;

            box-shadow:
                0 7px 18px rgba(37, 99, 235, 0.22);
        }


        .menu a.active::before {
            content: "";

            position: absolute;

            left: -12px;

            top: 7px;

            width: 3px;

            height: calc(100% - 14px);

            border-radius: 0 5px 5px 0;

            background: #60a5fa;
        }


        .menu-icon {
            width: 23px;

            min-width: 23px;

            text-align: center;

            font-size: 16px;

            line-height: 1;
        }


        /* =========================================================
           LOGOUT
        ========================================================= */

        .logout-section {
            margin: 22px 12px;

            padding-top: 16px;

            border-top:
                1px solid rgba(255, 255, 255, 0.08);
        }


        .logout-btn {
            width: 100%;

            border: none;

            background: transparent;

            color: #fca5a5;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 11px 13px;

            border-radius: 10px;

            cursor: pointer;

            font-size: 13px;

            font-weight: 500;

            text-align: left;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }


        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.15);

            color: #fecaca;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .main {
            margin-left: 250px;

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(37, 99, 235, 0.06),
                    transparent 30%
                ),
                var(--background);
        }


        /* =========================================================
           NAVBAR
        ========================================================= */

        .navbar {
            height: 70px;

            background:
                rgba(255, 255, 255, 0.96);

            border-bottom:
                1px solid var(--border);

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 30px;

            position: sticky;

            top: 0;

            z-index: 900;

            backdrop-filter: blur(10px);
        }


        .page-title {
            font-size: 20px;

            font-weight: 800;

            color: #0f172a;

            letter-spacing: -0.3px;
        }


        .page-subtitle {
            color: var(--muted);

            font-size: 12px;

            margin-top: 3px;
        }


        .navbar-right {
            display: flex;

            align-items: center;

            gap: 13px;
        }


        .user-info {
            text-align: right;
        }


        .user-name {
            font-size: 13px;

            font-weight: 700;

            color: #0f172a;
        }


        .user-role {
            font-size: 10px;

            color: #64748b;

            text-transform: capitalize;

            margin-top: 2px;
        }


        .user-avatar {
            width: 40px;
            height: 40px;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            color: white;

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 800;

            font-size: 14px;

            box-shadow:
                0 5px 15px rgba(37, 99, 235, 0.20);
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .content {
            padding: 30px;
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .page-header {
            margin-bottom: 24px;
        }


        .page-header h1 {
            font-size: 28px;

            font-weight: 800;

            color: #0f172a;

            margin-bottom: 5px;

            letter-spacing: -0.5px;
        }


        .page-header p {
            color: #64748b;

            font-size: 14px;
        }


        /* =========================================================
           DASHBOARD TITLE
        ========================================================= */

        .dashboard-title {
            margin-bottom: 24px;
        }


        .dashboard-title h1 {
            font-size: 30px;

            font-weight: 800;

            color: #0f172a;

            margin: 0;
        }


        .dashboard-title p {
            margin-top: 5px;

            color: #64748b;

            font-size: 14px;
        }


        /* =========================================================
           STATISTICS GRID
        ========================================================= */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 22px;
        }


        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 22px;
        }


        /* =========================================================
           STAT CARD
        ========================================================= */

        .stat-card {
            position: relative;

            overflow: hidden;

            background: #ffffff;

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 20px;

            min-height: 112px;

            display: flex;

            align-items: center;

            gap: 16px;

            box-shadow:
                0 4px 12px rgba(15, 23, 42, 0.04);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                border-color 0.2s ease;
        }


        .stat-card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #7c3aed
                );
        }


        .stat-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 12px 28px rgba(15, 23, 42, 0.09);

            border-color: #cbd5e1;
        }


        .stat-card .stat-icon,
        .stat-icon {
            width: 52px;

            min-width: 52px;

            height: 52px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            font-size: 22px;

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #dbeafe
                );

            color: #2563eb;
        }


        .stat-info {
            flex: 1;
        }


        .stat-label {
            font-size: 12px;

            color: #64748b;

            margin-bottom: 5px;

            font-weight: 500;
        }


        .stat-number,
        .stat-value {
            font-size: 25px;

            font-weight: 800;

            color: #0f172a;

            line-height: 1;
        }


        .stat-card span {
            color: #64748b;

            font-size: 12px;
        }


        .stat-card strong {
            display: block;

            font-size: 25px;

            font-weight: 800;

            color: #0f172a;
        }


        /* =========================================================
           DASHBOARD GRID
        ========================================================= */

        .dashboard-grid {
            display: grid;

            grid-template-columns:
                1.25fr 1fr;

            gap: 18px;

            margin-bottom: 20px;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .card {
            background: #ffffff;

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 20px;

            margin-bottom: 20px;

            box-shadow:
                0 4px 14px rgba(15, 23, 42, 0.04);

            overflow: hidden;

            transition:
                box-shadow 0.2s ease,
                transform 0.2s ease;
        }


        .card:hover {
            box-shadow:
                0 10px 25px rgba(15, 23, 42, 0.07);
        }


        /* =========================================================
           CARD HEADER
        ========================================================= */

        .card-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 18px 20px;

            margin: -20px -20px 18px;

            border-bottom:
                1px solid #eef2f7;

            background: #ffffff;
        }


        .card-header h3,
        .card-title {
            margin: 0;

            font-size: 16px;

            font-weight: 700;

            color: #0f172a;
        }


        .card-description {
            color: #64748b;

            font-size: 13px;

            margin-top: 5px;
        }


        .card-header a {
            font-size: 12px;

            font-weight: 600;

            color: #2563eb;

            text-decoration: none;
        }


        .card-header a:hover {
            color: #1d4ed8;

            text-decoration: underline;
        }


        /* =========================================================
           TABLE
        ========================================================= */

        .table-responsive {
            width: 100%;

            overflow-x: auto;
        }


        table {
            width: 100%;

            border-collapse: collapse;
        }


        table th {
            padding: 12px 14px;

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 0.4px;

            color: #64748b;

            background: #f8fafc;

            border-bottom:
                1px solid #e2e8f0;

            font-weight: 700;

            text-align: left;
        }


        table td {
            padding: 12px 14px;

            font-size: 12px;

            color: #334155;

            border-bottom:
                1px solid #f1f5f9;

            vertical-align: middle;
        }


        table tbody tr {
            transition:
                background 0.15s ease;
        }


        table tbody tr:hover {
            background: #f8fafc;
        }


        table tbody tr:last-child td {
            border-bottom: none;
        }


        .dashboard-grid table th {
            padding: 12px 14px;
        }


        .dashboard-grid table td {
            padding: 12px 14px;
        }


        .dashboard-grid table td a {
            color: #2563eb;

            font-weight: 600;

            text-decoration: none;
        }


        .dashboard-grid table td a:hover {
            color: #1d4ed8;

            text-decoration: underline;
        }


        /* =========================================================
           ACTIVITY LOG
        ========================================================= */

        .activity-table {
            width: 100%;
        }


        .activity-table th {
            background: #f8fafc;
        }


        .activity-table td {
            vertical-align: middle;
        }


        .activity-user {
            font-weight: 600;

            color: #0f172a;
        }


        .activity-action {
            font-weight: 600;

            color: #2563eb;
        }


        .activity-description {
            color: #64748b;
        }


        /* =========================================================
           BADGE
        ========================================================= */

        .badge {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 5px 9px;

            border-radius: 999px;

            font-size: 10px;

            font-weight: 700;

            line-height: 1;
        }


        .badge-success {
            color: #047857;

            background: #d1fae5;
        }


        .badge-danger {
            color: #b91c1c;

            background: #fee2e2;
        }


        .badge-warning {
            color: #b45309;

            background: #fef3c7;
        }


        .badge-primary {
            color: #1d4ed8;

            background: #dbeafe;
        }


        /* =========================================================
           REVENUE CARD
        ========================================================= */

        .revenue-card {
            position: relative;

            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #1e293b 50%,
                    #312e81 100%
                );

            border: none;

            border-radius: 18px;

            padding: 25px 28px;

            color: #ffffff;

            box-shadow:
                0 12px 30px rgba(15, 23, 42, 0.16);

            margin-top: 20px;

            margin-bottom: 20px;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        .revenue-card::before {
            content: "";

            position: absolute;

            width: 180px;

            height: 180px;

            right: -60px;

            top: -80px;

            background:
                rgba(255, 255, 255, 0.08);

            border-radius: 50%;
        }


        .revenue-card::after {
            content: "";

            position: absolute;

            width: 100px;

            height: 100px;

            right: 80px;

            bottom: -60px;

            background:
                rgba(96, 165, 250, 0.12);

            border-radius: 50%;
        }


        .revenue-card span,
        .revenue-label {
            position: relative;

            z-index: 2;

            color: #cbd5e1;

            font-size: 12px;

            margin-bottom: 7px;
        }


        .revenue-card h2,
        .revenue-value {
            position: relative;

            z-index: 2;

            font-size: 28px;

            font-weight: 800;

            color: #ffffff;
        }


        .revenue-card a {
            position: relative;

            z-index: 3;

            color: #bfdbfe;

            font-size: 12px;

            font-weight: 600;

            text-decoration: none;
        }


        .revenue-card a:hover {
            color: #ffffff;

            text-decoration: underline;
        }


        /* =========================================================
           FILTER
        ========================================================= */

        .filter-form {
            display: flex;

            align-items: flex-end;

            gap: 15px;

            flex-wrap: wrap;

            background: #ffffff;
        }


        .form-group {
            display: flex;

            flex-direction: column;

            gap: 7px;
        }


        .form-group label {
            font-size: 12px;

            font-weight: 600;

            color: #475569;
        }


        .form-group input,
        .form-group select,
        .form-control {
            height: 40px;

            padding: 0 12px;

            border:
                1px solid #cbd5e1;

            border-radius: 9px;

            background: #ffffff;

            color: #0f172a;

            font-size: 13px;

            outline: none;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }


        .form-group input,
        .form-group select {
            min-width: 180px;
        }


        .form-control:focus,
        .form-group input:focus,
        .form-group select:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.10);
        }


        textarea.form-control {
            height: auto;

            min-height: 100px;

            padding: 10px 12px;

            resize: vertical;
        }


        .form-actions {
            display: flex;

            gap: 8px;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .btn {
            border: none;

            border-radius: 9px;

            padding: 9px 15px;

            font-size: 12px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease,
                background 0.15s ease;
        }


        .btn:hover {
            transform: translateY(-1px);
        }


        .btn-primary {
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            color: #ffffff;

            box-shadow:
                0 4px 12px
                rgba(37, 99, 235, 0.20);
        }


        .btn-primary:hover {
            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #4338ca
                );
        }


        .btn-warning {
            background: #f59e0b;

            color: #ffffff;
        }


        .btn-danger {
            background: #ef4444;

            color: #ffffff;
        }


        .btn-secondary {
            background: #e2e8f0;

            color: #334155;
        }


        .btn-success {
            background: #10b981;

            color: #ffffff;
        }


        /* =========================================================
           ALERT
        ========================================================= */

        .alert {
            border-radius: 10px;

            padding: 13px 16px;

            margin-bottom: 18px;

            font-size: 13px;
        }


        .alert-success {
            background: #ecfdf5;

            color: #047857;

            border:
                1px solid #a7f3d0;
        }


        .alert-danger,
        .alert-error {
            background: #fef2f2;

            color: #b91c1c;

            border:
                1px solid #fecaca;
        }


        .alert-warning {
            background: #fffbeb;

            color: #b45309;

            border:
                1px solid #fde68a;
        }


        .alert-info {
            background: #eff6ff;

            color: #1d4ed8;

            border:
                1px solid #bfdbfe;
        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination {
            display: flex;

            align-items: center;

            gap: 5px;

            list-style: none;

            padding: 0;

            margin: 20px 0 0;
        }


        .pagination a,
        .pagination span {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 34px;

            height: 34px;

            padding: 0 9px;

            border-radius: 8px;

            font-size: 12px;

            text-decoration: none;

            border: 1px solid #e2e8f0;

            background: #ffffff;

            color: #475569;
        }


        .pagination a:hover {
            background: #eff6ff;

            color: #2563eb;

            border-color: #bfdbfe;
        }


        .pagination .active span,
        .pagination span[aria-current="page"] {
            background: #2563eb;

            color: #ffffff;

            border-color: #2563eb;
        }


        /* =========================================================
           QUICK MENU
        ========================================================= */

        .quick-menu {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;
        }


        .quick-item {
            text-decoration: none;

            padding: 18px;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;

            color: #374151;

            background: #ffffff;

            transition:
                border-color 0.2s ease,
                background 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }


        .quick-item:hover {
            border-color: #93c5fd;

            background: #eff6ff;

            transform: translateY(-3px);

            box-shadow:
                0 8px 20px
                rgba(37, 99, 235, 0.08);
        }


        .quick-icon {
            font-size: 24px;

            margin-bottom: 10px;
        }


        .quick-title {
            font-size: 14px;

            font-weight: 700;
        }


        .quick-description {
            color: #6b7280;

            font-size: 12px;

            margin-top: 4px;
        }


        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {
            text-align: center;

            padding: 35px 20px;

            color: #64748b;
        }


        .empty-state-icon {
            font-size: 35px;

            margin-bottom: 10px;

            opacity: 0.7;
        }


        .empty-state-title {
            font-size: 14px;

            font-weight: 700;

            color: #334155;

            margin-bottom: 5px;
        }


        .empty-state-text {
            font-size: 12px;

            color: #64748b;
        }


        /* =========================================================
           TEXT UTILITY
        ========================================================= */

        .text-center {
            text-align: center;
        }


        .text-right {
            text-align: right;
        }


        .text-muted {
            color: #64748b;
        }


        .fw-bold {
            font-weight: 700;
        }


        /* =========================================================
           RESPONSIVE 1200
        ========================================================= */

        @media (max-width: 1200px) {

            .stats-grid,
            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }


            .dashboard-grid {
                grid-template-columns: 1fr;
            }

        }


        /* =========================================================
           RESPONSIVE 1000
        ========================================================= */

        @media (max-width: 1000px) {

            .quick-menu {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }


        /* =========================================================
           RESPONSIVE 768
        ========================================================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 220px;
            }


            .main {
                margin-left: 220px;
            }


            .content {
                padding: 20px;
            }


            .navbar {
                padding: 0 20px;
            }


            .stats-grid,
            .stats {
                grid-template-columns: 1fr;
            }


            .page-header h1 {
                font-size: 24px;
            }


            .dashboard-title h1 {
                font-size: 25px;
            }


            .quick-menu {
                grid-template-columns: 1fr;
            }


            .user-info {
                display: none;
            }


            .filter-form {
                flex-direction: column;

                align-items: stretch;
            }


            .form-group input,
            .form-group select {
                width: 100%;

                min-width: 0;
            }


            .form-actions {
                display: flex;

                gap: 8px;
            }

        }


        /* =========================================================
           RESPONSIVE 600
        ========================================================= */

        @media (max-width: 600px) {

            .sidebar {
                width: 200px;
            }


            .main {
                margin-left: 200px;
            }


            .logo {
                padding: 0 15px;
            }


            .logo-text {
                font-size: 14px;
            }


            .menu {
                padding: 0 9px;
            }


            .menu-title {
                padding-left: 15px;
            }


            .navbar {
                height: 64px;

                padding: 0 15px;
            }


            .page-title {
                font-size: 17px;
            }


            .content {
                padding: 15px;
            }


            .revenue-card {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }


            .card {
                padding: 16px;
            }


            .card-header {
                margin:
                    -16px -16px 16px;

                padding:
                    15px 16px;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    @include('partials.sidebar')


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <div class="main">


        {{-- =====================================================
             NAVBAR
        ====================================================== --}}

        @include('partials.navbar')


        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <main class="content">


            {{-- =================================================
                 SUCCESS MESSAGE
            ================================================== --}}

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- =================================================
                 ERROR MESSAGE
            ================================================== --}}

            @if(session('error'))

                <div class="alert alert-error">
                    {{ session('error') }}
                </div>

            @endif


            {{-- =================================================
                 CONTENT PAGE
            ================================================== --}}

            @yield('content')


        </main>


    </div>


    @stack('scripts')


</body>

</html>