<x-app-layout>
    <x-slot name="header">
        <h2>Dashboard</h2>
    </x-slot>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap:1.5rem; margin-bottom:2rem;">
        <div style="background:white; border-radius:14px; padding:2rem; box-shadow:0 4px 12px rgba(0,0,0,0.06); border-top:4px solid #1f73e8; text-align:center;">
            <p style="font-size:0.85rem; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.5rem;">Enrolled Courses</p>
            <p style="font-size:2.5rem; font-weight:bold; color:#1f73e8;">
                {{ Auth::user()->enrollments()->where('expires_at', '>', now())->count() }}
            </p>
        </div>
        <div style="background:white; border-radius:14px; padding:2rem; box-shadow:0 4px 12px rgba(0,0,0,0.06); border-top:4px solid #28a745; text-align:center;">
            <p style="font-size:0.85rem; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.5rem;">Active Until</p>
            <p style="font-size:1.2rem; font-weight:bold; color:#28a745;">
                @php
                    $latest = Auth::user()->enrollments()->where('expires_at', '>', now())->orderBy('expires_at', 'desc')->first();
                @endphp
                {{ $latest ? $latest->expires_at->format('M d, Y') : 'No active enrollment' }}
            </p>
        </div>
        
    </div>

    <div style="background:white; border-radius:14px; padding:2rem; box-shadow:0 4px 12px rgba(0,0,0,0.06);">
        <h3 style="font-size:1.1rem; margin-bottom:1.5rem; color:#1a1a1a;">My Enrollments</h3>

        @php
            $enrollments = Auth::user()->enrollments()->with('course')->where('expires_at', '>', now())->get();
        @endphp

        @forelse($enrollments as $enrollment)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:1rem; border:1px solid #eee; border-radius:8px; margin-bottom:0.8rem;">
                <div>
                    <p style="font-weight:600; color:#1a1a1a;">{{ $enrollment->course->course_name }}</p>
                    <p style="font-size:0.85rem; color:#888; margin-top:0.2rem;">
                        {{ ucfirst($enrollment->type) }} — expires {{ $enrollment->expires_at->format('M d, Y') }}
                    </p>
                </div>
                <span style="background:#e8f4fd; color:#1f73e8; padding:0.3rem 0.8rem; border-radius:20px; font-size:0.8rem; font-weight:bold;">
                    Active
                </span>
            </div>
        @empty
            <div style="text-align:center; padding:3rem; color:#888;">
                <p style="font-size:1rem; margin-bottom:1rem;">You have no active enrollments.</p>
                <a href="{{ route('member.index') }}" style="background:#1f73e8; color:white; padding:0.7rem 1.5rem; border-radius:8px; text-decoration:none; font-weight:bold;">Browse Courses</a>
            </div>
        @endforelse
    </div>

</x-app-layout>