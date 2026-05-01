<x-app-layout>
    <x-slot name="header">
        <h2>Courses</h2>
    </x-slot>

    <style>
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: white;
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            border-top: 4px solid #1f73e8;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .course-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #1a1a1a;
        }

        .course-description {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }

        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem;
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
            margin-bottom: 1.5rem;
        }

        .status-box {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.8rem;
            text-align: center;
        }

        .status-pending {
            background: #fff8e1;
        }

        .status-approved {
            background: #e8f4fd;
        }

        .course-actions {
            display: flex;
            gap: 0.6rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 0.8rem;
        }

        .btn-primary,
        .btn-outline,
        .btn-danger,
        .btn-disabled {
            display: inline-block;
            width: 100%;
            padding: 0.7rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9rem;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background: #1f73e8;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #155db5;
        }

        .btn-outline {
            background: white;
            color: #1f73e8;
            border: 1px solid #1f73e8;
        }

        .btn-danger {
            background: white;
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .btn-disabled {
            background: #e5e7eb;
            color: #9ca3af;
            border: none;
            cursor: not-allowed;
        }

        .enroll-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-card {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 460px;
            position: relative;
            max-height: 92vh;
            overflow-y: auto;
        }

        .plan-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: transparent;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            color: #888;
            padding: 0;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .course-card {
                padding: 1.2rem;
                border-radius: 12px;
            }

            .course-title {
                font-size: 1.05rem;
            }

            .course-description {
                font-size: 0.86rem;
            }

            .course-price {
                font-size: 1.15rem;
            }

            .course-meta {
                align-items: flex-start;
                flex-direction: column;
            }

            .course-actions {
                flex-direction: column;
            }

            .course-actions a {
                width: 100%;
            }

            .plan-grid {
                grid-template-columns: 1fr;
            }

            .modal-card {
                border-radius: 12px;
            }
        }

        @media (max-width: 420px) {
            .course-card {
                padding: 1rem;
            }

            .status-box {
                padding: 0.85rem;
            }

            .btn-primary,
            .btn-outline,
            .btn-danger,
            .btn-disabled {
                font-size: 0.85rem;
                padding: 0.65rem;
            }
        }
    </style>

    @if(session('success'))
        <div style="background:#e9f9ee; color:#1f8b43; padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-weight:bold;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fde8e8; color:#c0392b; padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-weight:bold;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fde8e8; color:#c0392b; padding:1rem; border-radius:8px; margin-bottom:1.5rem;">
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="courses-grid">
        @forelse($courses as $course)
            @php
                $enrollment = Auth::user()->enrollments
                    ->where('course_id', $course->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->first();
            @endphp

            <div class="course-card">
                <div>
                    <h3 class="course-title">{{ $course->course_name }}</h3>

                    <p class="course-description">{{ $course->description }}</p>

                    <div class="course-meta">
                        <span class="course-price">
                            ₱{{ number_format($course->price, 2) }}/mo
                        </span>

                        <span class="course-slots">
                            {{ $course->slot - $course->enrollments_count }} slots left
                        </span>
                    </div>

                    <p class="course-instructor">
                        Instructor:
                        <strong style="color:#1f73e8;">{{ $course->staff->user->name }}</strong>
                    </p>
                </div>

                <div>
                    @if($enrollment)
                        @if($enrollment->status === 'pending')
                            <div class="status-box status-pending">
                                <p style="color:#f0ad4e; font-weight:bold;">Awaiting Staff Approval</p>
                                <p style="color:#888; font-size:0.8rem; margin-top:0.2rem;">
                                    Payment received. A staff member will approve your enrollment shortly.
                                </p>
                            </div>

                            <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn-danger"
                                    onclick="return confirm('Cancel this enrollment request?')">
                                    Cancel Request
                                </button>
                            </form>
                        @elseif($enrollment->status === 'approved')
                            <div class="status-box status-approved">
                                <p style="color:#1f73e8; font-weight:bold;">Enrolled</p>

                                <p style="color:#888; font-size:0.8rem; margin-top:0.2rem;">
                                    Expires {{ $enrollment->expires_at->format('M d, Y') }}
                                </p>

                                <div class="course-actions">
                                    <a href="{{ route('member.learnings') }}" class="btn-primary">
                                        My Learnings
                                    </a>

                                    <a href="{{ route('enrollment.receipt', $enrollment->id) }}" class="btn-outline">
                                        View Receipt
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        @if($course->slot - $course->enrollments_count > 0)
                            <button onclick="openModal({{ $course->id }}, '{{ addslashes($course->course_name) }}', {{ $course->price }})"
                                class="btn-primary">
                                Enroll Now
                            </button>
                        @else
                            <button disabled class="btn-disabled">
                                Full - No Slots Available
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:4rem; color:#888;">
                <p style="font-size:1.1rem;">No courses available yet.</p>
            </div>
        @endforelse
    </div>

    <div id="enrollModal" class="enroll-modal">
        <div class="modal-card">
            <button onclick="closeModal()" class="modal-close">x</button>

            <h3 style="font-size:1.2rem; font-weight:bold; margin:0; padding:1.5rem 2rem 0;" id="modalCourseName"></h3>
            <p style="font-size:0.85rem; color:#888; padding:0.3rem 2rem 1.2rem;">Choose your plan to continue.</p>

            <form id="enrollForm" method="POST" style="padding:0 2rem 2rem;">
                @csrf

                <div style="margin-bottom:1.2rem;">
                    <label style="font-size:0.85rem; font-weight:bold; color:#333; display:block; margin-bottom:0.5rem;">Select Plan</label>

                    <div class="plan-grid">
                        <label id="monthlyLabel" onclick="setPlan('monthly')"
                            style="border:2px solid #1f73e8; border-radius:8px; padding:1rem; cursor:pointer; text-align:center; background:#e8f4fd;">
                            <input type="radio" name="type" value="monthly" checked style="display:none;">
                            <p style="font-weight:bold; color:#1f73e8; font-size:0.9rem; margin:0 0 0.3rem;">Monthly</p>
                            <p id="monthlyPrice" style="font-size:1.1rem; font-weight:bold; color:#1a1a1a; margin:0;"></p>
                        </label>

                        <label id="yearlyLabel" onclick="setPlan('yearly')"
                            style="border:2px solid #ddd; border-radius:8px; padding:1rem; cursor:pointer; text-align:center;">
                            <input type="radio" name="type" value="yearly" style="display:none;">
                            <p style="font-weight:bold; color:#666; font-size:0.9rem; margin:0 0 0.3rem;">Yearly</p>
                            <p id="yearlyPrice" style="font-size:1.1rem; font-weight:bold; color:#1a1a1a; margin:0;"></p>
                            <p style="font-size:0.7rem; color:#1f8b43; font-weight:bold; margin:0.3rem 0 0;">Save 2 months!</p>
                        </label>
                    </div>
                </div>

                <div style="background:#f8f9fc; border-radius:8px; padding:0.8rem 1rem; margin-bottom:1rem; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.9rem; color:#666;">Amount Due</span>
                    <span id="amountDue" style="font-size:1.2rem; font-weight:bold; color:#1f73e8;"></span>
                </div>

                <div style="background:#f0f7ff; border:1px solid #bee3f8; border-radius:8px; padding:0.8rem 1rem; margin-bottom:1.5rem;">
                    <p style="font-size:0.82rem; color:#1f73e8; font-weight:bold; margin:0 0 0.3rem;">Accepted Payment Methods</p>
                    <p style="font-size:0.8rem; color:#555; margin:0;">GCash, Maya, Credit/Debit Card, Online Banking</p>
                    <p style="font-size:0.75rem; color:#888; margin:0.4rem 0 0;">You will be redirected to a secure payment page.</p>
                </div>

                <button type="submit" id="payBtn" class="btn-primary">
                    Pay Now
                </button>
            </form>
        </div>
    </div>

    <script>
        let currentPrice = 0;

        function openModal(courseId, courseName, price) {
            currentPrice = price;

            document.getElementById('modalCourseName').textContent = courseName;
            document.getElementById('enrollForm').action = '/courses/' + courseId + '/checkout';
            document.getElementById('monthlyPrice').textContent = '₱' + parseFloat(price).toFixed(2);
            document.getElementById('yearlyPrice').textContent = '₱' + (price * 10).toFixed(2);
            document.getElementById('amountDue').textContent = '₱' + parseFloat(price).toFixed(2);

            setPlan('monthly');

            document.getElementById('enrollModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function setPlan(plan) {
            const amount = plan === 'monthly' ? currentPrice : currentPrice * 10;
            document.getElementById('amountDue').textContent = '₱' + parseFloat(amount).toFixed(2);
            document.querySelectorAll('input[name="type"]').forEach(r => r.checked = r.value === plan);

            const monthly = document.getElementById('monthlyLabel');
            const yearly = document.getElementById('yearlyLabel');

            if (plan === 'monthly') {
                monthly.style.border = '2px solid #1f73e8';
                monthly.style.background = '#e8f4fd';
                monthly.querySelector('p').style.color = '#1f73e8';
                yearly.style.border = '2px solid #ddd';
                yearly.style.background = 'white';
                yearly.querySelector('p').style.color = '#666';
            } else {
                yearly.style.border = '2px solid #1f73e8';
                yearly.style.background = '#e8f4fd';
                yearly.querySelector('p').style.color = '#1f73e8';
                monthly.style.border = '2px solid #ddd';
                monthly.style.background = 'white';
                monthly.querySelector('p').style.color = '#666';
            }
        }

        function closeModal() {
            document.getElementById('enrollModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        document.getElementById('enrollModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('enrollForm').addEventListener('submit', function() {
            const btn = document.getElementById('payBtn');
            btn.disabled = true;
            btn.textContent = 'Redirecting to payment...';
        });
    </script>
</x-app-layout>
