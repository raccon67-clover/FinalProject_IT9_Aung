<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LearnFlow') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #222;
        }

        .main-nav {
            background: #1f73e8;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 65px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .nav-brand img {
            width: 40px;
            height: 40px;
        }

        .nav-brand h1 {
            color: white;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-user {
            position: relative;
        }

        .nav-user-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .nav-user-btn:hover {
            background: rgba(255,255,255,0.25);
        }

        .nav-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            min-width: 180px;
            overflow: hidden;
            z-index: 200;
        }

        .nav-dropdown.open {
            display: block;
        }

        .nav-dropdown a,
        .nav-dropdown button {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            text-align: left;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            background: white;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .nav-dropdown a:hover,
        .nav-dropdown button:hover {
            background: #f4f6f9;
            color: #1f73e8;
        }

        .nav-dropdown .divider {
            height: 1px;
            background: #eee;
            margin: 0.3rem 0;
        }

        .page-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.2rem 2rem;
        }

        .page-header h2 {
            font-size: 1.3rem;
            color: #1a1a1a;
            font-weight: 600;
        }

        .page-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media(max-width: 800px) {
            .main-nav {
                height: auto;
                padding: 1rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .nav-links {
                order: 3;
                width: 100%;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

    <nav class="main-nav">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <img src="/image_laravel/logo.png" alt="logo">
            <h1>LearnFlow</h1>
        </a>

        <div class="nav-links">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('member.index') }}"
                class="{{ request()->routeIs('member.index') ? 'active' : '' }}">
                Courses
            </a>

            <a href="{{ route('member.learnings') }}"
                class="{{ request()->routeIs('member.learnings') ? 'active' : '' }}">
                My Learning
            </a>
        </div>

        <div class="nav-right">
            <div class="nav-user">
                <button class="nav-user-btn" onclick="toggleDropdown()">
                    {{ Auth::user()->name }}
                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="nav-dropdown" id="userDropdown">
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    <div class="divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @isset($header)
        <div class="page-header">
            {{ $header }}
        </div>
    @endisset

    <div class="page-content">
        {{ $slot }}
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const user = document.querySelector('.nav-user');
            if (user && !user.contains(e.target)) {
                document.getElementById('userDropdown').classList.remove('open');
            }
        });
    </script>

</body>
</html>
