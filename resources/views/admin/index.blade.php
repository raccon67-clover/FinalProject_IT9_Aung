<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}

        body{
            font-family:Arial, Helvetica, sans-serif;
            background:#f4f6f9;
            display:flex;
            color:#222;
        }

        /* SIDEBAR */
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

        .sidebar h2{font-size:28px;margin-bottom:20px;}

        .sidebar hr{
            border:none;
            height:1px;
            background:rgba(255,255,255,.4);
            margin-bottom:20px;
        }

        /* SIDE NAV */
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

        /* MAIN CONTENT */
        .main-content{margin-left:240px;width:100%;padding:40px;}

        /* SECTION BOXES */
        .users,.courses,.reports{
            background:white;
            padding:30px;
            border-radius:14px;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
            margin-bottom:35px;
        }

        h2{font-size:30px;margin-bottom:25px;}

        /* STATS */
        .stats{display:flex;gap:20px;margin-bottom:30px;}

        .card{
            flex:1;
            background:#f8f9fc;
            border-radius:12px;
            padding:25px;
            text-align:center;
            border:1px solid #eee;
        }

        .card h3{font-size:16px;color:#666;margin-bottom:10px;}
        .card p{font-size:40px;font-weight:bold;}

        /* TABLE */
        table{width:100%;border-collapse:collapse;margin-top:15px;}
        th{background:#f5f6fa;padding:14px;text-align:left;font-size:14px;}
        td{padding:14px;border-bottom:1px solid #eee;vertical-align:middle;}
        tr:hover{background:#fafafa;}

        /* ACTION COLUMN */
        td:last-child{white-space:nowrap;}

        td:last-child > div{
            display:flex;
            gap:8px;
            align-items:center;
            justify-content:center;
        }

        td:last-child form{margin:0;padding:0;}
        td form{margin:0;}

        /* BUTTONS */
        button{
            border:none;
            padding:8px 14px;
            border-radius:6px;
            cursor:pointer;
            font-size:14px;
            display:inline-block;
            background:#1f73e8;
            color:white;
        }

        button:hover{background:#165bc0;}

        /* LINKS */
        a{
            padding:8px 14px;
            border-radius:6px;
            cursor:pointer;
            font-size:14px;
            text-decoration:none;
            display:inline-block;
            background:#28a745;
            color:white;
        }

        a:hover{background:#1e7e34;}

        /* COURSE FORM */
        .courses form{margin-bottom:30px;}
        .courses label{display:block;font-weight:bold;margin-bottom:5px;}

        .courses input,
        .courses textarea,
        .courses select{
            width:100%;
            padding:11px;
            border:1px solid #ddd;
            border-radius:8px;
            margin-bottom:15px;
        }

        .courses textarea{height:110px;resize:none;}

        /* SUCCESS */
        .alert-success{
            background:#e9f9ee;
            color:#1f8b43;
            padding:12px;
            border-radius:8px;
            margin-bottom:20px;
            font-weight:bold;
        }

        /* SEARCH */
        .search-form{
            display:flex;
            gap:0.5rem;
            align-items:center;
            margin-top:1rem;
            margin-bottom:1rem;
        }

        .search-form input{
            padding:0.5rem 1rem;
            border:1px solid #ddd;
            border-radius:6px;
            font-size:0.9rem;
            width:300px;
            outline:none;
            transition:border 0.2s;
            margin-bottom:0 !important;
            background:white;
        }

        .search-form input:focus{border-color:#1f73e8;}

        .search-form button{
            padding:0.5rem 1.2rem !important;
            background:#1f73e8 !important;
            color:white !important;
            border:none;
            border-radius:6px !important;
            cursor:pointer;
            font-size:0.9rem !important;
            width:auto !important;
            margin-bottom:0 !important;
        }

        .search-form button:hover{background:#165bc0 !important;}

        .search-form a{
            padding:0.5rem 1rem !important;
            color:#888 !important;
            background:transparent !important;
            font-size:0.85rem !important;
            text-decoration:none;
            border:1px solid #ccc;
            border-radius:6px !important;
            transition:all 0.2s;
        }

        .search-form a:hover{
            color:#333 !important;
            background:transparent !important;
            border-color:#333;
        }

        /* REPORT HEADER ROW */
        .report-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:20px;
        }

        .report-header h2 { margin-bottom:0; }

        .btn-print {
            background:#dc3545 !important;
            color:white !important;
            padding:10px 20px !important;
            border-radius:8px !important;
            font-size:14px !important;
            font-weight:bold !important;
            cursor:pointer !important;
            border:none !important;
        }

        .btn-print:hover { background:#b02a37 !important; }

        /* GRAND TOTAL ROW */
        .grand-total td {
            font-weight:bold;
            background:#eef2fc;
            border-top:2px solid #1f73e8;
            border-bottom:none;
        }

        /* =====================
           PRINT STYLES
        ===================== */
        @media print {

            /* Hide everything that isn't the report */
            .sidebar,
            #section-users,
            #section-courses,
            .alert-success,
            .btn-print { display:none !important; }

            /* Reset layout — no sidebar offset */
            body { background:white; display:block; }
            .main-content { margin-left:0; padding:0; }

            /* Clean up the report card */
            .reports {
                box-shadow:none !important;
                border:none !important;
                border-radius:0 !important;
                padding:0 !important;
                margin:0 !important;
            }

            /* Print header — shown only when printing */
            .print-only { display:block !important; }

            /* Force table borders to show on paper */
            table { border-collapse:collapse; width:100%; }
            th, td { border:1px solid #bbb !important; padding:10px 12px !important; }

            /* Keep the blue header colour when printing */
            thead th {
                background:#1f73e8 !important;
                color:white !important;
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            /* Keep grand total highlight when printing */
            .grand-total td {
                background:#eef2fc !important;
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            /* No hover effect on paper */
            tr:hover { background:none !important; }
        }

        /* Hide the print-only header on screen */
        .print-only { display:none; }

        @media(max-width:900px){
            .sidebar{width:100%;height:auto;position:relative;}
            .main-content{margin-left:0;padding:20px;}
            .stats{flex-direction:column;}
            table{display:block;overflow-x:auto;}
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <hr>

        <nav class="side-nav">
            <button onclick="showSection('all')" class="nav-link active" id="nav-all">Dashboard</button>
            <button onclick="showSection('users')" class="nav-link" id="nav-users">Users</button>
            <button onclick="showSection('courses')" class="nav-link" id="nav-courses">Courses</button>
            <button onclick="showSection('reports')" class="nav-link" id="nav-reports">Reports</button>
        </nav>

        <hr>

        <div class="logout">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>


    <div class="main-content">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- USERS --}}
        <div class="section-wrapper" id="section-users">
            <div class="users">
                <h2>User Management</h2>
                <div class="stats">
                    <div class="card">
                        <h3>Total Users</h3>
                        <p>{{ $users->where('email','!=','admin@1234')->count() }}</p>
                    </div>
                    <div class="card">
                        <h3>Total Staff</h3>
                        <p>{{ $staff->count() }}</p>
                    </div>
                    <div class="card">
                        <h3>Total Courses</h3>
                        <p>{{ $courses->count() }}</p>
                    </div>
                </div>

                <label style="font-weight:bold;">User Search</label><br>
                <form method="GET" action="{{ route('admin.index') }}" class="search-form">
                    <input type="text" name="search_user" placeholder="Search user by name or email..."
                        value="{{ request('search_user') }}">
                    <button type="submit">Search</button>
                    @if(request('search_user'))
                        <a href="{{ route('admin.index') }}">Clear</a>
                    @endif
                </form>

                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    @foreach($users as $user)
                        @if($user->email !== 'admin@1234')
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->staff)
                                        <span style="color:green;font-weight:bold;">STAFF</span>
                                    @else
                                        <span style="color:gray;">USER</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        @if(!$user->staff)
                                            <form action="{{ route('staff.promote', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" style="background:#1f73e8;">Promote</button>
                                            </form>
                                        @endif

                                        @if($user->staff)
                                            <form action="{{ route('staff.demote', $user->id) }}" method="POST" onsubmit="return confirm('Remove staff access?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background:#f0ad4e;">Demote</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:#dc3545;">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>

        {{-- COURSES --}}
        <div class="section-wrapper" id="section-courses">
            <div class="courses">
                <h2>Course Management</h2>

                @if(isset($editcourses) && $editcourses)
                    <form action="{{ route('courses.update', $editcourses->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('courses.store') }}" method="POST">
                @endif
                    @csrf

                    <label>Course name:</label>
                    <input type="text" name="course_name" placeholder="Course Name"
                        value="{{ isset($editcourses) ? $editcourses->course_name : '' }}" required>

                    <label>Description:</label>
                    <textarea name="description" placeholder="Description" required>{{ isset($editcourses) ? $editcourses->description : '' }}</textarea>

                    <label>Price:</label>
                    <input type="number" step="0.01" name="price" placeholder="Price"
                        value="{{ isset($editcourses) ? $editcourses->price : '' }}" required>

                    <label>Slot:</label>
                    <input type="number" name="slot" placeholder="Slot"
                        value="{{ isset($editcourses) ? $editcourses->slot : '' }}" required>

                    <label>Instructor:</label>
                    <select name="staff_id">
                        <option value="">-- Select Staff --</option>
                        @foreach($staff as $s)
                            <option value="{{ $s->id }}"
                                {{ isset($editcourses) && $editcourses->staff_id == $s->id ? 'selected' : '' }}>
                                {{ $s->user->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit">{{ isset($editcourses) ? 'Update Course' : 'Add Course' }}</button>

                    @if(isset($editcourses))
                        <a href="{{ route('admin.index') }}">Cancel</a>
                    @endif
                </form>

                <label style="font-weight:bold;">Course Search</label>
                <form method="GET" action="{{ route('admin.index') }}" class="search-form">
                    <input type="text" name="search_course" placeholder="Search course by name..."
                        value="{{ request('search_course') }}">
                    <button type="submit">Search</button>
                    @if(request('search_course'))
                        <a href="{{ route('admin.index') }}">Clear</a>
                    @endif
                </form>

                <table>
                    <tr>
                        <th>Course</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Slot</th>
                        <th>Instructor</th>
                        <th>Action</th>
                    </tr>

                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ $course->description }}</td>
                            <td>{{ $course->price }}</td>
                            <td>{{ $course->slot }}</td>
                            <td>{{ $course->staff->user->name }}</td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.index', ['edit' => $course->id]) }}" style="background:#28a745;">Edit</a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:#dc3545;" onclick="return confirm('Delete this course?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- REPORTS --}}
        <div class="section-wrapper" id="section-reports">
            <div class="reports">

                {{-- Header row: title + print button --}}
                <div class="report-header">
                    <h2>Subscription Reports</h2>
                    <button class="btn-print" onclick="window.print()">🖨 Print / Save as PDF</button>
                </div>

                {{-- Shown only when printing --}}
                <div class="print-only" style="margin-bottom:18px; border-bottom:2px solid #1f73e8; padding-bottom:12px;">
                    <p style="font-size:11px; color:#666;">Generated: {{ now()->format('F d, Y \a\t h:i A') }}</p>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Slots</th>
                            <th>Enrolled</th>
                            <th>Total Earned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($courses as $i => $course)
                            @php $grandTotal += $course->enrollments_sum_amount_paid ?? 0; @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->description }}</td>
                                <td>&#8369;{{ number_format($course->price, 2) }}</td>
                                <td>{{ $course->slot }}</td>
                                <td>{{ $course->enrollments_count }}</td>
                                <td>&#8369;{{ number_format($course->enrollments_sum_amount_paid ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="grand-total">
                            <td colspan="6" style="text-align:right;">Grand Total Earned:</td>
                            <td>&#8369;{{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>

    </div>

    <script>
        function showSection(section) {
            document.querySelectorAll('.section-wrapper').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));

            if (section === 'all') {
                document.querySelectorAll('.section-wrapper').forEach(el => el.style.display = 'block');
            } else {
                document.getElementById('section-' + section).style.display = 'block';
            }

            document.getElementById('nav-' + section).classList.add('active');
        }

        @if(isset($editcourses) && $editcourses)
            showSection('courses');
        @else
            showSection('all');
        @endif
    </script>

</body>
</html>