<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}

        body{
            font-family:Arial, Helvetica, sans-serif;
            background:#f4f6f9;
            display:flex;
            color:#222;
        }

        .sidebar{
            width:240px;
            height:100vh;
            background:#1f73e8;
            position:fixed;
            top:0;
            left:0;
            padding:30px 20px;
            color:white;
            display:flex;
            flex-direction:column;
        }

        .sidebar h2{font-size:24px;margin-bottom:6px;}

        .staff-name{
            font-size:1rem;
            font-weight:bold;
            margin-bottom:20px;
            color:rgba(255,255,255,0.92);
        }

        .sidebar hr{
            border:none;
            height:1px;
            background:rgba(255,255,255,.4);
            margin-bottom:20px;
        }

        .side-nav{
            display:flex;
            flex-direction:column;
            gap:6px;
            margin-bottom:20px;
        }

        .nav-link{
            display:block;
            padding:10px 14px;
            border-radius:8px;
            color:white;
            background:transparent;
            font-size:0.95rem;
            cursor:pointer;
            text-decoration:none;
            transition:background 0.2s;
            border:none;
            text-align:left;
            width:100%;
        }

        .nav-link:hover{background:rgba(255,255,255,0.15);}
        .nav-link.active{background:rgba(255,255,255,0.25);font-weight:bold;}

        .logout{margin-top:auto;}

        .logout button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:8px;
            background:white;
            color:#1f73e8;
            font-weight:bold;
            cursor:pointer;
        }

        .logout button:hover{background:#e8eefc;}

        .main-content{
            margin-left:240px;
            width:100%;
            padding:40px;
        }

        .page-title{
            font-size:1.6rem;
            font-weight:bold;
            margin-bottom:24px;
            color:#1a1a1a;
        }

        .profile-card{
            background:white;
            border-radius:14px;
            padding:28px;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
            margin-bottom:24px;
            max-width:760px;
        }

        .profile-card h2{
            font-size:1.2rem;
            margin-bottom:8px;
            color:#1a1a1a;
        }

        .profile-card p{
            font-size:0.9rem;
            color:#777;
            margin-bottom:20px;
        }

        .form-group{
            margin-bottom:16px;
        }

        label{
            display:block;
            font-size:0.85rem;
            font-weight:bold;
            color:#333;
            margin-bottom:6px;
        }

        input{
            width:100%;
            padding:11px 12px;
            border:1px solid #ddd;
            border-radius:8px;
            font-size:0.95rem;
        }

        input:focus{
            outline:none;
            border-color:#1f73e8;
        }

        .btn-primary{
            background:#1f73e8;
            color:white;
            border:none;
            padding:10px 18px;
            border-radius:8px;
            font-weight:bold;
            cursor:pointer;
        }

        .btn-primary:hover{background:#155db5;}

        .alert-success{
            background:#e9f9ee;
            color:#1f8b43;
            padding:12px 16px;
            border-radius:8px;
            margin-bottom:20px;
            font-weight:bold;
            max-width:760px;
        }

        .alert-error{
            background:#fde8e8;
            color:#c0392b;
            padding:12px 16px;
            border-radius:8px;
            margin-bottom:20px;
            max-width:760px;
        }

        @media(max-width:900px){
            body{display:block;}
            .sidebar{width:100%;height:auto;position:relative;}
            .main-content{margin-left:0;padding:20px;}
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Staff Panel</h2>
        <p class="staff-name">{{ Auth::user()->name }}</p>
        <hr>

        <nav class="side-nav">
            <a href="{{ route('staff.panel') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('staff.panel') }}" class="nav-link">Pending</a>
            <a href="{{ route('staff.panel') }}" class="nav-link">My Courses</a>
            <a href="{{ route('staff.panel') }}" class="nav-link">Reports</a>
            <a href="{{ route('staff.profile') }}" class="nav-link active">Profile</a>
        </nav>

        <hr>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <h1 class="page-title">Profile</h1>

        @if(session('status') === 'profile-updated')
            <div class="alert-success">Profile updated successfully.</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-card">
            <h2>Profile Information</h2>
            <p>Update your account name and email address.</p>

            <form method="POST" action="{{ route('staff.profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <button type="submit" class="btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

</body>
</html>
