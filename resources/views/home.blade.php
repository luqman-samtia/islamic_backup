@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="premium-dashboard">

    {{-- ===== Hero / Greeting ===== --}}
    <div class="dash-hero">
        <div class="dash-hero__bg"></div>
        <div class="dash-hero__content">
            <div class="dash-hero__text">
                <span class="dash-hero__eyebrow">
                    @php
                        $hour = (int) date('H');
                        $greet = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
                    @endphp
                    {{ $greet }}
                </span>
                <h1 class="dash-hero__title">{{ Auth::user()->name }}</h1>
                <p class="dash-hero__sub">
                    @if(Auth::user()->type == 'student')
                        Continue your learning journey and track your progress.
                    @elseif(Auth::user()->type == 'scholar')
                        Review your students and manage their lessons.
                    @else
                        Here's an overview of your platform today.
                    @endif
                </p>
            </div>
            <div class="dash-hero__badge">
                <span class="dash-hero__role">{{ ucfirst(Auth::user()->type ?? 'Admin') }}</span>
                <span class="dash-hero__date">{{ date('l, d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ===== Cards ===== --}}
    <div class="dash-grid">

        @if (Auth::check() && Auth::user()->type == 'student')

            <a href="{{ route('fees.my-report') }}" class="dash-card" data-accent="indigo">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-money"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <h3 class="dash-card__label">Fee Report</h3>
                    <p class="dash-card__desc">View your payment history and dues</p>
                </div>
            </a>

            <a href="{{ route('lessons.my') }}" class="dash-card" data-accent="rose">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-book"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <h3 class="dash-card__label">My Lessons</h3>
                    <p class="dash-card__desc">Access your scheduled lessons</p>
                </div>
            </a>

            <a href="{{ route('student.update-password') }}" class="dash-card" data-accent="emerald">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-lock"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <h3 class="dash-card__label">Update Password</h3>
                    <p class="dash-card__desc">Keep your account secure</p>
                </div>
            </a>

        @elseif (Auth::check() && Auth::user()->type == 'scholar')

            <a href="{{ route('scholars.students') }}" class="dash-card" data-accent="indigo">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-users"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <h3 class="dash-card__label">View Students</h3>
                    <p class="dash-card__desc">Manage and review your students</p>
                </div>
            </a>

        @else

            <a href="{{ route('resources') }}" class="dash-card dash-card--stat" data-accent="indigo">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-list"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <span class="dash-card__value">{{ $resources }}</span>
                    <h3 class="dash-card__label">Islamic Resources</h3>
                </div>
            </a>

            <a href="{{ route('quran') }}" class="dash-card dash-card--stat" data-accent="emerald">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-book"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <span class="dash-card__value">{{ $surah }}</span>
                    <h3 class="dash-card__label">Total Surahs</h3>
                </div>
            </a>

            <a href="{{ route('articals') }}" class="dash-card dash-card--stat" data-accent="amber">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-file-text"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <span class="dash-card__value">{{ $articles }}</span>
                    <h3 class="dash-card__label">Total Articles</h3>
                </div>
            </a>

            <a href="{{ route('admin.lessons.report') }}" class="dash-card" data-accent="rose">
                <div class="dash-card__top">
                    <span class="dash-card__icon"><i class="fa fa-bar-chart"></i></span>
                    <span class="dash-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </div>
                <div class="dash-card__body">
                    <h3 class="dash-card__label">Student Report</h3>
                    <p class="dash-card__desc">View student lessons &amp; progress</p>
                </div>
            </a>
        @endif

    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --pd-bg: #f6f7fb;
        --pd-surface: #ffffff;
        --pd-ink: #0f1729;
        --pd-muted: #6b7588;
        --pd-line: #eceef4;

        --pd-indigo: #4f46e5;
        --pd-indigo-soft: #eef0fe;
        --pd-rose: #e11d6b;
        --pd-rose-soft: #fdeef4;
        --pd-emerald: #0f9d6b;
        --pd-emerald-soft: #e7f7f0;
        --pd-amber: #c79f1a;
        --pd-amber-soft: #fbf4dd;
    }

    .content-wrapper { background: var(--pd-bg) !important; }

    .premium-dashboard {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        padding: 4px 2px 24px;
    }

    /* ---------- HERO ---------- */
    .dash-hero {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        margin-bottom: 28px;
        background: linear-gradient(115deg, #1a1f3a 0%, #2d2461 55%, #4f46e5 100%);
        box-shadow: 0 18px 40px -22px rgba(47, 38, 110, 0.6);
    }
    .dash-hero__bg {
        position: absolute; inset: 0;
        background-image:
            radial-gradient(circle at 88% 18%, rgba(199,159,26,0.30), transparent 42%),
            radial-gradient(circle at 70% 120%, rgba(225,29,107,0.25), transparent 45%);
    }
    .dash-hero__content {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 18px;
        padding: 34px 36px;
    }
    .dash-hero__eyebrow {
        display: inline-block;
        font-size: 12px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        font-weight: 600;
        color: rgba(255,255,255,0.62);
        margin-bottom: 8px;
    }
    .dash-hero__title {
        font-size: 34px;
        line-height: 1.1;
        font-weight: 700;
        color: #fff;
        margin: 0 0 10px;
        letter-spacing: -0.02em;
    }
    .dash-hero__sub {
        font-size: 15px;
        color: rgba(255,255,255,0.72);
        margin: 0;
        max-width: 460px;
    }
    .dash-hero__badge {
        text-align: right;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-end;
    }
    .dash-hero__role {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #fff;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.22);
        padding: 6px 14px;
        border-radius: 999px;
        backdrop-filter: blur(6px);
    }
    .dash-hero__date {
        font-size: 13px;
        color: rgba(255,255,255,0.62);
    }

    /* ---------- GRID ---------- */
    .dash-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    /* ---------- CARD ---------- */
    .dash-card {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 168px;
        padding: 22px 22px 20px;
        background: var(--pd-surface);
        border: 1px solid var(--pd-line);
        border-radius: 18px;
        text-decoration: none;
        overflow: hidden;
        transition: transform .28s cubic-bezier(.2,.7,.3,1), box-shadow .28s, border-color .28s;
        box-shadow: 0 1px 2px rgba(16,23,41,0.04);
    }
    .dash-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: var(--_accent);
        transform: scaleY(0);
        transform-origin: top;
        transition: transform .3s ease;
    }
    .dash-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 38px -20px rgba(16,23,41,0.28);
        border-color: transparent;
        text-decoration: none;
    }
    .dash-card:hover::before { transform: scaleY(1); }

    .dash-card[data-accent="indigo"]  { --_accent: var(--pd-indigo);  --_soft: var(--pd-indigo-soft); }
    .dash-card[data-accent="rose"]    { --_accent: var(--pd-rose);    --_soft: var(--pd-rose-soft); }
    .dash-card[data-accent="emerald"] { --_accent: var(--pd-emerald); --_soft: var(--pd-emerald-soft); }
    .dash-card[data-accent="amber"]   { --_accent: var(--pd-amber);   --_soft: var(--pd-amber-soft); }

    .dash-card__top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dash-card__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px; height: 50px;
        border-radius: 14px;
        background: var(--_soft);
        color: var(--_accent);
        font-size: 20px;
        transition: transform .3s ease;
    }
    .dash-card:hover .dash-card__icon { transform: scale(1.06) rotate(-3deg); }
    .dash-card__arrow {
        width: 34px; height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--pd-muted);
        background: var(--pd-bg);
        font-size: 13px;
        transition: all .3s ease;
    }
    .dash-card:hover .dash-card__arrow {
        background: var(--_accent);
        color: #fff;
        transform: translateX(2px);
    }

    .dash-card__body { margin-top: 16px; }
    .dash-card__value {
        display: block;
        font-size: 36px;
        font-weight: 700;
        line-height: 1;
        color: var(--pd-ink);
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }
    .dash-card__label {
        font-size: 16px;
        font-weight: 600;
        color: var(--pd-ink);
        margin: 0 0 4px;
    }
    .dash-card__desc {
        font-size: 13.5px;
        color: var(--pd-muted);
        margin: 0;
        line-height: 1.45;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 575px) {
        .dash-hero__content { padding: 26px 22px; }
        .dash-hero__title { font-size: 26px; }
        .dash-hero__badge { align-items: flex-start; text-align: left; }
        .dash-grid { grid-template-columns: 1fr; }
    }

    @media (prefers-reduced-motion: reduce) {
        .dash-card, .dash-card__icon, .dash-card__arrow, .dash-card::before { transition: none; }
        .dash-card:hover { transform: none; }
    }
</style>
@stop