<x-app-layout>
    <x-slot name="header">
        <h2>My Learnings</h2>
    </x-slot>

    @if(session('success'))
        <div style="background:#e9f9ee; color:#1f8b43; padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-weight:bold;">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('member.learnings') }}" style="margin-bottom:1.5rem;">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Search my learnings..."
            style="width:100%; padding:0.85rem 1rem; border:1px solid #ddd; border-radius:10px; font-size:0.95rem;"
        >
    </form>

    <div style="display:flex; flex-direction:column; gap:1.5rem;">
        @forelse($enrollments as $enrollment)
            @php
                $contents = $enrollment->course->contents;
                $contentsCount = $contents->count();

                $completedCount = $contents->filter(function ($content) {
                    return $content->completedByUsers->contains('id', Auth::id());
                })->count();

                $progress = $contentsCount > 0 ? round(($completedCount / $contentsCount) * 100) : 0;
            @endphp

            <div style="background:white; border-radius:14px; padding:2rem; box-shadow:0 4px 12px rgba(0,0,0,0.06); border-left:5px solid #1f73e8; width:100%;">
                <h3 style="font-size:1.2rem; font-weight:bold; margin-bottom:0.5rem; color:#1a1a1a;">
                    {{ $enrollment->course->course_name }}
                </h3>

                <p style="font-size:0.9rem; color:#666; line-height:1.6; margin-bottom:1rem;">
                    {{ $enrollment->course->description }}
                </p>

                <p style="font-size:0.85rem; color:#555; margin-bottom:1rem;">
                    Instructor:
                    <strong style="color:#1f73e8;">{{ $enrollment->course->staff->user->name }}</strong>
                </p>

                <div style="background:#e8f4fd; border-radius:8px; padding:1rem; margin-bottom:1.2rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                        <p style="color:#1f73e8; font-weight:bold;">Progress</p>
                        <p style="color:#1f73e8; font-weight:bold;">{{ $progress }}%</p>
                    </div>

                    <div style="height:8px; background:#d7e7fb; border-radius:20px; overflow:hidden;">
                        <div style="height:100%; width:{{ $progress }}%; background:#1f73e8;"></div>
                    </div>

                    <p style="font-size:0.8rem; color:#666; margin-top:0.5rem;">
                        {{ $completedCount }} of {{ $contentsCount }} lessons completed
                    </p>
                </div>

                <h4 style="font-size:1rem; font-weight:bold; margin-bottom:0.8rem;">Course Content</h4>

                @forelse($contents as $content)
                    @php
                        $isCompleted = $content->completedByUsers->contains('id', Auth::id());
                    @endphp

                    <div style="background:#f8f9fc; border:1px solid #eee; border-radius:10px; padding:1rem; margin-bottom:0.8rem;">
                        <div style="display:flex; justify-content:space-between; gap:1rem; align-items:flex-start;">
                            <div style="flex:1; min-width:0; width:100%;">
                                <h5 style="font-size:0.95rem; font-weight:bold; margin-bottom:0.4rem;">
                                    {{ $content->title }}
                                </h5>

                                @if($content->body)
                                    <p style="font-size:0.88rem; color:#555; line-height:1.5; margin-bottom:0.6rem;">
                                        {{ $content->body }}
                                    </p>
                                @endif

                                @if($content->video_url)
                                    @php
                                        $videoUrl = $content->video_url;
                                        $embedUrl = null;

                                        if (str_contains($videoUrl, 'youtube.com/watch')) {
                                            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query);
                                            $embedUrl = isset($query['v']) ? 'https://www.youtube.com/embed/' . $query['v'] : null;
                                        } elseif (str_contains($videoUrl, 'youtu.be/')) {
                                            $videoId = trim(parse_url($videoUrl, PHP_URL_PATH), '/');
                                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                        } elseif (str_contains($videoUrl, 'youtube.com/embed/')) {
                                            $embedUrl = $videoUrl;
                                        }
                                    @endphp

                                    @if($embedUrl)
                                        <div style="margin:0.8rem auto 0; width:100%; max-width:760px; aspect-ratio:16 / 9; background:#000; border-radius:10px; overflow:hidden;">
                                            <iframe src="{{ $embedUrl }}" title="{{ $content->title }}"
                                                style="width:100%; height:100%; border:0;"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                    @else
                                        <a href="{{ $content->video_url }}" target="_blank"
                                            style="display:inline-block; color:#1f73e8; font-weight:bold; text-decoration:none;">
                                            Open Lesson
                                        </a>
                                    @endif
                                @endif
                            </div>

                            @if($isCompleted)
                                <span style="background:#e9f9ee; color:#1f8b43; padding:0.4rem 0.7rem; border-radius:20px; font-size:0.8rem; font-weight:bold; white-space:nowrap;">
                                    Completed
                                </span>
                            @else
                                <form method="POST" action="{{ route('member.learnings.complete', $content->id) }}">
                                    @csrf
                                    <button type="submit"
                                        style="background:#1f73e8; color:white; border:none; padding:0.5rem 0.8rem; border-radius:8px; cursor:pointer; font-weight:bold; white-space:nowrap;">
                                        Mark Complete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p style="color:#888; background:#f8f9fc; padding:1rem; border-radius:8px;">
                        No content has been added yet.
                    </p>
                @endforelse

                @if($enrollment->status === 'unenroll_pending')
                    <div style="margin-top:1rem; padding:0.8rem; background:#fff8e1; color:#b7791f; border-radius:8px; font-weight:bold; text-align:center;">
                        Unenroll request pending staff approval
                    </div>
                @else
                    <form action="{{ route('member.enrollments.request-unenroll', $enrollment->id) }}" method="POST" style="margin-top:1rem;">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            style="width:100%; padding:0.7rem; background:white; color:#dc3545; border:1px solid #dc3545; border-radius:8px; cursor:pointer; font-weight:bold;"
                            onclick="return confirm('Request to unenroll from this course?')">
                            Request Unenroll
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div style="text-align:center; padding:4rem; color:#888; background:white; border-radius:14px;">
                <p style="font-size:1.1rem; margin-bottom:1rem;">No learnings found.</p>
                <a href="{{ route('member.index') }}" style="color:#1f73e8; font-weight:bold; text-decoration:none;">
                    Browse Courses
                </a>
            </div>
        @endforelse
    </div>
</x-app-layout>
