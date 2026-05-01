<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Panel</title>
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

        .sidebar h2{font-size:24px;margin-bottom:6px;}

        /* BIGGER USERNAME */
        .sidebar .staff-name{
            font-size:1rem;
            font-weight:bold;
            opacity:1;
            margin-bottom:20px;
            color:rgba(255,255,255,0.92);
            letter-spacing:0.2px;
        }

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

        /* ALERTS */
        .alert-success{
            background:#e9f9ee;
            color:#1f8b43;
            padding:12px 16px;
            border-radius:8px;
            margin-bottom:24px;
            font-weight:bold;
        }

        /* STATS */
        .stats{
            display:flex;
            gap:20px;
            margin-bottom:30px;
        }

        .stat-card{
            flex:1;
            background:white;
            border-radius:12px;
            padding:24px;
            text-align:center;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
            border-top:4px solid #ddd;
        }

        .stat-card.blue{border-top-color:#1f73e8;}
        .stat-card.green{border-top-color:#28a745;}
        .stat-card.yellow{border-top-color:#f0ad4e;}
        .stat-card.red{border-top-color:#dc3545;}

        .stat-card h3{font-size:13px;color:#888;margin-bottom:10px;text-transform:uppercase;letter-spacing:0.5px;}
        .stat-card p{font-size:2rem;font-weight:bold;color:#1a1a1a;}

        /* SECTION BOXES */
        .section-box{
            background:white;
            border-radius:14px;
            padding:28px;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
            margin-bottom:28px;
        }

        .section-box h2{
            font-size:1.4rem;
            font-weight:bold;
            margin-bottom:20px;
            color:#1a1a1a;
        }

        /* COURSE CARD */
        .course-card{
            background:white;
            border-radius:14px;
            padding:24px;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
            margin-bottom:20px;
        }

        .course-header{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            margin-bottom:20px;
            flex-wrap:wrap;
            gap:1rem;
        }

        .course-header-left h3{font-size:1.1rem;font-weight:bold;margin-bottom:4px;}
        .course-header-left p{font-size:0.85rem;color:#888;}

        .course-meta-tags{display:flex;gap:10px;flex-wrap:wrap;}

        .meta-tag{
            background:#f8f9fc;
            border-radius:8px;
            padding:10px 16px;
            text-align:center;
            border:1px solid #eee;
            min-width:80px;
        }

        .meta-tag span{display:block;font-size:0.72rem;color:#888;margin-bottom:2px;text-transform:uppercase;}
        .meta-tag strong{font-size:1rem;color:#1a1a1a;}
        .meta-tag.blue strong{color:#1f73e8;}
        .meta-tag.green strong{color:#28a745;}
        .meta-tag.yellow strong{color:#f0ad4e;}

        /* TABLE */
        table{width:100%;border-collapse:collapse;margin-top:8px;}
        th{background:#f5f6fa;padding:12px 14px;text-align:left;font-size:13px;color:#555;}
        td{padding:12px 14px;border-bottom:1px solid #f0f0f0;vertical-align:middle;font-size:0.9rem;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#fafafa;}

        /* BADGES */
        .badge{
            padding:3px 10px;
            border-radius:20px;
            font-size:0.75rem;
            font-weight:bold;
        }

        .badge-monthly{background:#e8f4fd;color:#1f73e8;}
        .badge-yearly{background:#e9f9ee;color:#1f8b43;}
        .badge-pending{background:#fff8e1;color:#f0ad4e;}
        .badge-approved{background:#e9f9ee;color:#1f8b43;}

        /* BUTTONS */
        .btn-remove{
            background:#fee2e2;
            color:#dc3545;
            border:none;
            padding:6px 12px;
            border-radius:6px;
            cursor:pointer;
            font-size:0.82rem;
            font-weight:bold;
        }

        .btn-remove:hover{background:#dc3545;color:white;}

        .btn-approve{
            background:#28a745;
            color:white;
            border:none;
            padding:6px 12px;
            border-radius:6px;
            cursor:pointer;
            font-size:0.82rem;
        }

        .btn-approve:hover{background:#218838;}

        .btn-reject{
            background:#fee2e2;
            color:#dc3545;
            border:none;
            padding:6px 12px;
            border-radius:6px;
            cursor:pointer;
            font-size:0.82rem;
            font-weight:bold;
        }

        .btn-reject:hover{background:#dc3545;color:white;}

        /* EMPTY STATE */
        .empty-state{
            text-align:center;
            padding:2rem;
            color:#aaa;
            font-size:0.9rem;
        }

        /* REPORT CARDS */
        .report-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(200px,1fr));
            gap:16px;
            margin-bottom:28px;
        }

        .report-card{
            background:#f8f9fc;
            border-radius:10px;
            padding:20px;
            border:1px solid #eee;
            text-align:center;
        }

        .report-card .label{font-size:0.8rem;color:#888;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;}
        .report-card .value{font-size:1.6rem;font-weight:bold;color:#1a1a1a;}
        .report-card .sub{font-size:0.78rem;color:#aaa;margin-top:4px;}

        /* PROGRESS BAR */
        .progress-wrap{margin-top:6px;}
        .progress-bar-bg{background:#eee;border-radius:20px;height:8px;overflow:hidden;margin-top:6px;}
        .progress-bar-fill{height:100%;border-radius:20px;background:#1f73e8;transition:width 0.4s;}

        /* REPORT HEADER */
        .report-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:20px;
        }

        .report-header h2{ margin-bottom:0; }

        .btn-print{
            background:#dc3545;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:8px;
            font-size:14px;
            font-weight:bold;
            cursor:pointer;
        }

        .btn-print:hover{ background:#b02a37; }

        /* Print-only timestamp */
        .print-only{ display:none; }

        /* =====================
           PRINT STYLES
        ===================== */
        @media print {

            .sidebar,
            #section-pending,
            #section-courses,
            .stats,
            .alert-success,
            .btn-print { display:none !important; }

            body{ background:white; display:block; }
            .main-content{ margin-left:0; padding:0; }

            .section-box{
                box-shadow:none !important;
                border:none !important;
                border-radius:0 !important;
                padding:0 !important;
                margin:0 !important;
            }

            .print-only{ display:block !important; }

            table{ border-collapse:collapse; width:100%; }
            th, td{ border:1px solid #bbb !important; padding:9px 12px !important; }

            thead th{
                background:#1f73e8 !important;
                color:white !important;
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            .report-grid{
                display:grid;
                grid-template-columns:repeat(4,1fr);
                gap:12px;
                margin-bottom:20px;
            }

            .report-card{
                border:1px solid #ccc !important;
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            .progress-bar-fill{
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            .badge{
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            tr:hover td{ background:none !important; }
        }

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
        <h2>Staff Panel</h2>
        <p class="staff-name">{{ Auth::user()->name }}</p>
        <hr>

        <nav class="side-nav">
            <button onclick="showSection('all')" class="nav-link active" id="nav-all">Dashboard</button>
            <button onclick="showSection('pending')" class="nav-link" id="nav-pending">Pending</button>
            <button onclick="showSection('courses')" class="nav-link" id="nav-courses">My Courses</button>
            <button onclick="showSection('reports')" class="nav-link" id="nav-reports">Reports</button>

            <a href="{{ route('staff.profile') }}" class="nav-link">Profile</a>
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

        @php
            $pendingAll = $courses->flatMap(fn($c) => $c->enrollments->where('status', 'pending'));
            $approvedAll = $courses->flatMap(fn($c) => $c->enrollments->where('status', 'approved'));
            $monthlyCount = $approvedAll->where('type', 'monthly')->count();
            $yearlyCount  = $approvedAll->where('type', 'yearly')->count();
        @endphp

        {{-- STATS --}}
        <div class="stats">
            <div class="stat-card blue">
                <h3>My Courses</h3>
                <p>{{ $courses->count() }}</p>
            </div>
            <div class="stat-card green">
                <h3>Total Enrolled</h3>
                <p>{{ $totalEnrolled }}</p>
            </div>
            <div class="stat-card yellow">
                <h3>Total Earned</h3>
                <p style="font-size:1.4rem;">&#8369;{{ number_format($totalEarned, 2) }}</p>
            </div>
            <div class="stat-card red">
                <h3>Pending</h3>
                <p>{{ $pendingAll->count() }}</p>
            </div>
        </div>

        {{-- PENDING ENROLLMENTS --}}
        <div class="section-wrapper" id="section-pending">
            <div class="section-box">
                <h2>Pending Enrollments</h2>

                @if($pendingAll->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingAll as $enrollment)
                                <tr>
                                    <td>
                                        <strong>{{ $enrollment->user->name }}</strong><br>
                                        <span style="font-size:0.78rem;color:#888;">{{ $enrollment->user->email }}</span>
                                    </td>
                                    <td>{{ $enrollment->course->course_name }}</td>
                                    <td><span class="badge badge-{{ $enrollment->type }}">{{ ucfirst($enrollment->type) }}</span></td>
                                    <td style="font-weight:bold;color:#f0ad4e;">&#8369;{{ number_format($enrollment->amount_paid, 2) }}</td>
                                    <td>
                                        <div style="display:flex;gap:8px;">
                                            <form action="{{ route('enrollments.approve', $enrollment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-approve">Approve</button>
                                            </form>
                                            <form action="{{ route('enrollments.reject', $enrollment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-reject">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">No pending enrollments.</div>
                @endif
            </div>
        </div>

        {{-- MY COURSES --}}
        <div class="section-wrapper" id="section-courses">
            <h2 style="font-size:1.4rem;font-weight:bold;margin-bottom:16px;">My Courses</h2>

            @forelse($courses as $course)
                <div class="course-card">
                    <div class="course-header">
                        <div class="course-header-left">
                            <h3>{{ $course->course_name }}</h3>
                            <p>{{ $course->description }}</p>
                        </div>
                        <div class="course-meta-tags">
                            <div class="meta-tag blue">
                                <span>Price</span>
                                <strong>&#8369;{{ number_format($course->price, 2) }}</strong>
                            </div>
                            <div class="meta-tag">
                                <span>Slots</span>
                                <strong>{{ $course->slot }}</strong>
                            </div>
                            <div class="meta-tag green">
                                <span>Enrolled</span>
                                <strong>{{ $course->enrollments_count }}</strong>
                            </div>
                            <div class="meta-tag yellow">
                                <span>Earned</span>
                                <strong>&#8369;{{ number_format($course->enrollments_sum_amount_paid, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background:#f8f9fc; border:1px solid #eee; border-radius:10px; padding:16px; margin-bottom:20px;">
                <h4 style="font-size:1rem; margin-bottom:12px;">Teaching Content</h4>

                <form method="POST" action="{{ route('staff.course-contents.store', $course->id) }}" style="display:grid; gap:10px;">
                    @csrf

                    <input type="text" name="title" placeholder="Lesson title" required
                        style="padding:10px; border:1px solid #ddd; border-radius:8px;">

                    <textarea name="body" placeholder="Lesson content"
                         style="padding:10px; border:1px solid #ddd; border-radius:8px; min-height:90px; resize:none;"></textarea>


                    <input type="url" name="video_url" placeholder="Video URL"
                        style="padding:10px; border:1px solid #ddd; border-radius:8px;">

                    <input type="number" name="sort_order" placeholder="Order" min="0"
                        style="padding:10px; border:1px solid #ddd; border-radius:8px;">

                    <button type="submit" class="btn-approve" style="width:max-content;">Add Content</button>
                </form>

                @forelse($course->contents as $content)
                    <div style="display:flex; justify-content:space-between; gap:12px; align-items:center; margin-top:12px; padding-top:12px; border-top:1px solid #eee;">
                        <div>
                            <strong>{{ $content->title }}</strong>

                            @if($content->body)
                                <p style="font-size:0.85rem; color:#666; margin-top:4px;">{{ $content->body }}</p>
                            @endif

                            @if($content->video_url)
                                <a href="{{ $content->video_url }}" target="_blank" style="font-size:0.8rem;color:#1f73e8;">
                                    View lesson
                                </a>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('staff.course-contents.destroy', $content->id) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-remove" onclick="return confirm('Delete this content?')">
                                Delete
                            </button>
                        </form>
                    </div>
                @empty
                    <p style="color:#888; font-size:0.85rem; margin-top:12px;">No teaching content yet.</p>
                @endforelse
            </div>

                    @php
                        $approvedEnrollments = $course->enrollments->where('status', 'approved');
                    @endphp

                    @if($approvedEnrollments->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Paid</th>
                                    <th>Expires</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedEnrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->user->name }}</td>
                                        <td style="color:#888;">{{ $enrollment->user->email }}</td>
                                        <td><span class="badge badge-{{ $enrollment->type }}">{{ ucfirst($enrollment->type) }}</span></td>
                                        <td style="font-weight:bold;color:#f0ad4e;">&#8369;{{ number_format($enrollment->amount_paid, 2) }}</td>
                                        <td style="color:#888;">{{ $enrollment->expires_at->format('M d, Y') }}</td>
                                        <td>
                                            <form action="{{ route('staff.enrollments.destroy', $enrollment->id) }}" method="POST"
                                                onsubmit="return confirm('Remove this enrollment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-remove">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">No approved enrollments yet for this course.</div>
                    @endif
                </div>
            @empty
                <div class="section-box" style="text-align:center;color:#888;padding:4rem;">
                    <p>You have no assigned courses yet.</p>
                </div>
            @endforelse
        </div>

        {{-- REPORTS --}}
        <div class="section-wrapper" id="section-reports">
            <div class="section-box">

                {{-- Header row: title + print button --}}
                <div class="report-header">
                    <h2>Reports &amp; Tracking</h2>
                    <button class="btn-print" onclick="window.print()">🖨 Print / Save as PDF</button>
                </div>

                {{-- Shown only when printing --}}
                <div class="print-only" style="margin-bottom:16px;border-bottom:2px solid #1f73e8;padding-bottom:12px;">
                    <p style="font-size:12px;color:#555;">Staff: <strong>{{ Auth::user()->name }}</strong> &nbsp;|&nbsp; Generated: {{ now()->format('F d, Y \a\t h:i A') }}</p>
                </div>

                {{-- Summary Cards --}}
                <div class="report-grid">
                    <div class="report-card">
                        <div class="label">Total Revenue</div>
                        <div class="value">&#8369;{{ number_format($totalEarned, 2) }}</div>
                        <div class="sub">All time</div>
                    </div>
                    <div class="report-card">
                        <div class="label">Active Students</div>
                        <div class="value">{{ $approvedAll->count() }}</div>
                        <div class="sub">Approved enrollments</div>
                    </div>
                    <div class="report-card">
                        <div class="label">Monthly Plans</div>
                        <div class="value">{{ $monthlyCount }}</div>
                        <div class="sub">Active subscribers</div>
                    </div>
                    <div class="report-card">
                        <div class="label">Yearly Plans</div>
                        <div class="value">{{ $yearlyCount }}</div>
                        <div class="sub">Active subscribers</div>
                    </div>
                </div>

                {{-- Per Course Breakdown --}}
                <h3 style="font-size:1rem;font-weight:bold;margin-bottom:16px;color:#555;">Per Course Breakdown</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Slots</th>
                            <th>Enrolled</th>
                            <th>Slot Usage</th>
                            <th>Monthly</th>
                            <th>Yearly</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            @php
                                $approved  = $course->enrollments->where('status', 'approved');
                                $monthly   = $approved->where('type', 'monthly')->count();
                                $yearly    = $approved->where('type', 'yearly')->count();
                                $revenue   = $approved->sum('amount_paid');
                                $slotPct   = $course->slot > 0 ? round(($approved->count() / $course->slot) * 100) : 0;
                            @endphp
                            <tr>
                                <td><strong>{{ $course->course_name }}</strong></td>
                                <td>{{ $course->slot }}</td>
                                <td>{{ $approved->count() }}</td>
                                <td style="min-width:120px;">
                                    <div class="progress-wrap">
                                        <span style="font-size:0.78rem;color:#888;">{{ $slotPct }}% filled</span>
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill" style="width:{{ $slotPct }}%;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-monthly">{{ $monthly }}</span></td>
                                <td><span class="badge badge-yearly">{{ $yearly }}</span></td>
                                <td style="font-weight:bold;color:#28a745;">&#8369;{{ number_format($revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Expiring Soon --}}
                @php
                    $expiringSoon = $approvedAll->filter(fn($e) => $e->expires_at && $e->expires_at->diffInDays(now()) <= 7 && $e->expires_at->isFuture())->sortBy('expires_at');
                @endphp

                @if($expiringSoon->count() > 0)
                    <h3 style="font-size:1rem;font-weight:bold;margin:24px 0 16px;color:#f0ad4e;">Expiring Within 7 Days</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Plan</th>
                                <th>Expires</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiringSoon as $enrollment)
                                <tr>
                                    <td><strong>{{ $enrollment->user->name }}</strong></td>
                                    <td>{{ $enrollment->course->course_name }}</td>
                                    <td><span class="badge badge-{{ $enrollment->type }}">{{ ucfirst($enrollment->type) }}</span></td>
                                    <td style="color:#f0ad4e;font-weight:bold;">{{ $enrollment->expires_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

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

        showSection('all');
    </script>

</body>
</html>