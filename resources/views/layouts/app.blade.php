<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Presentation Review')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --danger-bg: #fff1f2;
            --danger-text: #be123c;
            --success-bg: #ecfdf5;
            --success-text: #047857;
        }

        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            background: #f3f4f6;
            border: 1px solid var(--border);
            font-size: 13px;
            color: var(--muted);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
        }

        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .app-header {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 14px 20px;
        }

        .app-header-inner {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .brand {
            font-weight: 800;
            color: var(--text);
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-nav form {
            margin: 0;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 24px 16px 48px;
        }

        .page-title {
            font-size: 28px;
            margin: 0 0 8px;
        }

        .page-lead {
            margin: 0 0 24px;
            color: var(--muted);
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 16px;
            border-radius: 10px;
            border: 0;
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
        }

        .button:hover {
            background: var(--primary-dark);
            text-decoration: none;
        }

        .button-secondary {
            background: #eef2ff;
            color: var(--primary);
        }

        .button-secondary:hover {
            background: #e0e7ff;
        }

        .button-plain {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--border);
        }

        .button-plain:hover {
            background: #f9fafb;
        }

        .button-full {
            width: 100%;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-help {
            margin-top: 6px;
            text-align: right;
            font-size: 14px;
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            background: white;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .hint,
        .muted {
            color: var(--muted);
            font-size: 14px;
        }

        .error {
            background: var(--danger-bg);
            color: var(--danger-text);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 20px;
        }

        .success {
            background: var(--success-bg);
            color: var(--success-text);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 20px;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-item {
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }

        .list-item:last-child {
            border-bottom: 0;
        }

        .list-title {
            font-weight: 800;
            font-size: 18px;
        }

        .url-box {
            word-break: break-all;
            background: #f9fafb;
            border: 1px solid var(--border);
            padding: 14px;
            border-radius: 12px;
        }

        .qr-box {
            text-align: center;
        }

        .qr-box svg {
            max-width: 280px;
            width: 100%;
            height: auto;
        }

        .score-options {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        .score-options label {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 0;
            text-align: center;
            cursor: pointer;
            background: white;
        }

        .score-options input {
            margin-right: 4px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }

        .summary-item {
            background: #f9fafb;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px;
            text-align: center;
        }

        .summary-item strong {
            display: block;
            font-size: 24px;
            margin-top: 4px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        th,
        td {
            border-bottom: 1px solid var(--border);
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f9fafb;
            font-size: 14px;
        }

        .comment {
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
        }

        .comment:last-child {
            border-bottom: 0;
        }

        @media (max-width: 640px) {
            .app-header-inner {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 24px;
            }

            .card {
                padding: 16px;
                border-radius: 14px;
            }

            .actions {
                flex-direction: column;
            }

            .actions .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="app-header">
        <div class="app-header-inner">
            <a class="brand" href="{{ auth()->check() ? route('home') : route('login') }}">Presentation Review</a>
            <div class="header-nav">
                @auth
                    <div class="muted">{{ auth()->user()->name }} / {{ auth()->user()->role }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button button-plain" type="submit">Log out</button>
                    </form>
                @else
                    <a class="button button-plain" href="{{ route('login') }}">Teacher log in</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
