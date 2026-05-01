<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #222;
        }

        /* NAV */
        nav {
            background: #1f73e8;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .nav-brand h1 {
            color: white;
            font-size: 1.4rem;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-links a {
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            font-size: 0.95rem;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-login {
            background: white;
            color: #1f73e8;
        }

        .btn-login:hover {
            background: #e8eefc;
        }

        .btn-register {
            background: #155db5;
            color: white;
            border: 1px solid white;
        }

        .btn-register:hover {
            background: #0f4a9c;
        }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1f73e8, #155db5);
            color: white;
            text-align: center;
            padding: 5rem 2rem;
        }

        .hero h2 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .hero a {
            display: inline-block;
            background: white;
            color: #1f73e8;
            padding: 0.9rem 2.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
        }

        .hero a:hover {
            background: #e8eefc;
        }

        /* COURSES */
        .courses-section {
            max-width: 1100px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .courses-section h2 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 0.5rem;
            color: #1f73e8;
        }

        .courses-section .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 2.5rem;
            font-size: 1rem;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: white;
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            border-top: 4px solid #1f73e8;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .course-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.6rem;
            color: #1a1a1a;
        }

        .course-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }

        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .course-price {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1f73e8;
        }

        .course-slots {
            font-size: 0.85rem;
            color: #888;
            background: #f4f6f9;
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
        }

        .course-instructor {
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 1.2rem;
        }

        .course-instructor span {
            color: #1f73e8;
            font-weight: bold;
        }

        .course-card a {
            display: block;
            text-align: center;
            background: #1f73e8;
            color: white;
            padding: 0.7rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        .course-card a:hover {
            background: #155db5;
        }

        /* WHY JOIN */
        .why-section {
            background: white;
            padding: 4rem 2rem;
            text-align: center;
        }

        .why-section h2 {
            font-size: 2rem;
            color: #1f73e8;
            margin-bottom: 0.5rem;
        }

        .why-section .subtitle {
            color: #666;
            margin-bottom: 2.5rem;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .why-card {
            padding: 1.5rem;
            border-radius: 12px;
            background: #f4f6f9;
        }

        .why-card .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .why-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #1a1a1a;
        }

        .why-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
        }

        /* CTA */
        .cta-section {
            background: linear-gradient(135deg, #1f73e8, #155db5);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
        }

        .cta-section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            opacity: 0.9;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .cta-section a {
            display: inline-block;
            background: white;
            color: #1f73e8;
            padding: 0.9rem 2.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
        }

        .cta-section a:hover {
            background: #e8eefc;
        }

        /* FOOTER */
        footer {
            background: #1a1a1a;
            color: #aaa;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.85rem;
        }

        /* MOBILE */
        @media(max-width: 600px) {
            .hero h2 { font-size: 1.8rem; }
            .courses-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="nav-brand">
            <img src="/image_laravel/logo.png" alt="logo" style="width:40px; height:40px;">
            <h1>LearnFlow</h1>
        </div>
        <div class="nav-links">
            <a href="{{ route('login') }}" class="btn-login">Log In</a>
            <a href="{{ route('register') }}" class="btn-register">Sign Up</a>
        </div>
    </nav>

    <div class="hero">
        <h2>Grow Your Skills Today</h2>
        <p>Join our membership and get access to expert-led courses designed to help you learn, grow, and succeed.</p>
        <a href="{{ route('register') }}">Get Started</a>
    </div>

    <div class="courses-section">
        <h2>Available Courses</h2>
        <p class="subtitle">Explore what's waiting for you when you join.</p>

        <div class="courses-grid">
            @forelse($courses as $course)
                <div class="course-card">
                    <h3>{{ $course->course_name }}</h3>
                    <p>{{ $course->description }}</p>
                    <div class="course-meta">
                        <span class="course-price">₱{{ number_format($course->price, 2) }}/mo</span>
                        <span class="course-slots">{{ $course->slot }} slots</span>
                    </div>
                    <div class="course-instructor">
                        Instructor: <span>{{ $course->staff->user->name }}</span>
                    </div>
                    <a href="{{ route('register') }}">Enroll Now</a>
                </div>
            @empty
                <p style="text-align:center; color:#888; grid-column:1/-1;">No courses available yet.</p>
            @endforelse
        </div>
    </div>

    <div class="why-section">
        <h2>Why Join Us?</h2>
        <p class="subtitle">Everything you need to level up.</p>
        <div class="why-grid">
            <div class="why-card">
                <div class="icon">🎓</div>
                <h3>Expert Instructors</h3>
                <p>Learn from experienced professionals who are passionate about teaching.</p>
            </div>
            <div class="why-card">
                <div class="icon">📅</div>
                <h3>Flexible Membership</h3>
                <p>Choose monthly or yearly plans that fit your schedule and budget.</p>
            </div>
            <div class="why-card">
                <div class="icon">🚀</div>
                <h3>Learn at Your Pace</h3>
                <p>Access your enrolled courses anytime and progress at your own speed.</p>
            </div>
            <div class="why-card">
                <div class="icon">🤝</div>
                <h3>Community Support</h3>
                <p>Join a growing community of learners and get the support you need.</p>
            </div>
        </div>
    </div>

    <div class="cta-section">
        <h2>Ready to Get Started?</h2>
        <p>Create your free account and start learning today.</p>
        <a href="{{ route('register') }}">Create Account</a>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} LearnFlow. All rights reserved.</p>
    </footer>

</body>
</html>