@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="header__logo" href="/">
                Atte
            </a>
            <nav>
                <ul class="header-nav-ul">
                    <li class="header-nav-li"><a class="header-nav-li-a" href="/">ホーム</a></li>
                    <li class="header-nav-li"><a class="header-nav-li-a" href="/attendance">日付一覧</a></li>
                    <li class="header-nav-li"><a class="header-nav-li-a" href="/users">ユーザー一覧</a></li>
                    <li class="header-nav-li">
                        <form class="form-logout" action="/logout" method="post">
                            @csrf
                            <button class="header-nav__li-button" type="submit">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="body">
    <div class="index__content">
        <div class="index__heading">
            <h2>{{ Auth::user()->name }}さんお疲れ様です！</h2>
        </div>
        <div class="index__button">
            <div class="index__button-work">
                <div class="index__button-work-start">
                    <form class="form-work-start" action="/start-work" method="post">
                        @csrf
                        <button class="form-work-start-button" type="submit" type="submit" {{ Auth::user()->work_status == 'working' || Auth::user()->work_status == 'on_break' ? 'disabled' : '' }}>勤務開始</button>
                    </form>
                </div>
                <div class="index__button-work-end">
                    <form class="form-work-end" action="/end-work" method="post">
                        @csrf
                        <button class="form-work-end-button" type="submit" {{ Auth::user()->work_status != 'working' ? 'disabled' : '' }}>勤務終了</button>
                    </form>
                </div>
            </div>
            <div class="index__button-break">
                <div class="index__button-break-start">
                    <form class="form-break-start" action="/start-break" method="post">
                        @csrf
                        <button class="form-break-start-button" type="submit" {{ Auth::user()->work_status != 'working' ? 'disabled' : '' }}>休憩開始</button>
                    </form>
                </div>
                <div class="index__button-break-end">
                    <form class="form-break-end" action="/end-break" method="post">
                        @csrf
                        <button class="form-break-end-button" type="submit" {{ Auth::user()->work_status != 'on_break' ? 'disabled' : '' }}>休憩終了</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer__inner">
        <div class="footer-utilities">
            <a class="footer__logo" href="/">
                Atte,inc.
            </a>
        </div>
    </div>
</footer>

@endsection