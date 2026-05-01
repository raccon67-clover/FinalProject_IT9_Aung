<x-app-layout>
    <x-slot name="header">
        <h2>Enrollment Receipt</h2>
    </x-slot>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 16mm;
            }

            body {
                background: white !important;
                color: #111 !important;
            }

            .main-nav,
            .page-header,
            .receipt-actions {
                display: none !important;
            }

            .page-content {
                padding: 0 !important;
                max-width: none !important;
                margin: 0 !important;
            }

            .receipt-wrap {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .receipt-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                border-radius: 10px !important;
                overflow: hidden !important;
                page-break-inside: avoid;
            }

            .receipt-header {
                background: #1f73e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .receipt-header * {
                color: white !important;
            }

            a {
                text-decoration: none !important;
            }
        }
    </style>

    <div class="receipt-wrap" style="max-width:600px; margin:0 auto;">
        <div class="receipt-card" style="background:white; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">

            <div class="receipt-header" style="background:#1f73e8; padding:2rem; text-align:center;">
                <p style="color:rgba(255,255,255,0.8); font-size:0.85rem; text-transform:uppercase; letter-spacing:2px;">Enrollment Receipt</p>
                <h2 style="color:white; font-size:1.8rem; margin:0.5rem 0;">Confirmed</h2>
                <p style="color:rgba(255,255,255,0.8); font-size:0.85rem;">{{ $enrollment->updated_at->format('F d, Y h:i A') }}</p>
            </div>

            <div style="padding:2rem;">
                <div style="border:1px solid #eee; border-radius:10px; overflow:hidden; margin-bottom:1.5rem;">
                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; border-bottom:1px solid #eee; background:#f8f9fc;">
                        <span style="font-size:0.85rem; color:#888;">Receipt No.</span>
                        <span style="font-size:0.85rem; font-weight:bold;">#{{ str_pad($enrollment->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; border-bottom:1px solid #eee;">
                        <span style="font-size:0.85rem; color:#888;">Student</span>
                        <span style="font-size:0.85rem; font-weight:bold;">{{ $enrollment->user->name }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; border-bottom:1px solid #eee;">
                        <span style="font-size:0.85rem; color:#888;">Course</span>
                        <span style="font-size:0.85rem; font-weight:bold;">{{ $enrollment->course->course_name }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; border-bottom:1px solid #eee;">
                        <span style="font-size:0.85rem; color:#888;">Instructor</span>
                        <span style="font-size:0.85rem; font-weight:bold;">{{ $enrollment->course->staff->user->name }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; border-bottom:1px solid #eee;">
                        <span style="font-size:0.85rem; color:#888;">Plan</span>
                        <span style="font-size:0.85rem; font-weight:bold; color:{{ $enrollment->type === 'yearly' ? '#1f73e8' : '#28a745' }};">
                            {{ ucfirst($enrollment->type) }}
                        </span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; border-bottom:1px solid #eee;">
                        <span style="font-size:0.85rem; color:#888;">Valid Until</span>
                        <span style="font-size:0.85rem; font-weight:bold;">{{ $enrollment->expires_at->format('F d, Y') }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:0.9rem 1.2rem; background:#f8f9fc;">
                        <span style="font-size:0.9rem; font-weight:bold; color:#333;">Amount Paid</span>
                        <span style="font-size:1.1rem; font-weight:bold; color:#1f73e8;">₱{{ number_format($enrollment->amount_paid, 2) }}</span>
                    </div>
                </div>

                <div class="receipt-actions" style="display:flex; gap:1rem;">
                    <a href="{{ route('member.index') }}"
                        style="flex:1; display:block; text-align:center; background:#f4f6f9; color:#1f73e8; padding:0.8rem; border-radius:8px; font-weight:bold; text-decoration:none;">
                        Back to Courses
                    </a>

                    <button onclick="window.print()"
                        style="flex:1; background:#1f73e8; color:white; border:none; padding:0.8rem; border-radius:8px; cursor:pointer; font-weight:bold;">
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
