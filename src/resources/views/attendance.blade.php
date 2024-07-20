@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')

<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="header__logo" href="/attendance">
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
    <div class="attendance__content">
        <div class="attendance__heading">
            <form action="/attendance" method="get" class="date-pagination-form">
                @php
                $today = \Carbon\Carbon::today();
                $currentDate = \Carbon\Carbon::parse($date);
                @endphp
                <button type="submit" name="date" value="{{ $currentDate->copy()->subDay()->toDateString() }}" class="date-pagination-button">＜</button>
                <span class="date-pagination">{{ $currentDate->format('Y-m-d') }}</span>
                <button type="submit" name="date" value="{{ $currentDate->copy()->addDay()->toDateString() }}" class="date-pagination-button" {{ $currentDate->eq($today) ? 'disabled' : '' }}>＞</button>
            </form>
        </div>
        <div class="worktime-table">
            <table class="worktime__inner">
                <tr class="worktime__row">
                    <th class="worktime__header">
                        <div class="worktime__header-div">名前</div>
                        <div class="worktime__header-div">勤務開始</div>
                        <div class="worktime__header-div">勤務終了</div>
                        <div class="worktime__header-div">休憩時間</div>
                        <div class="worktime__header-div">勤務時間</div>
                        <div class="worktime__header-div"></div>
                    </th>
                </tr>
                @foreach ($worktimes as $worktime)
                <tr class="worktime__row">
                    <form class="form-worktime" action="" method="get">
                        <td class="worktime__item">
                            <div class="worktime__item-div-name">
                                <a href="{{ route('users.show', $worktime['user']['id']) }}" class="worktime__itme-a">{{ $worktime['user']['name'] }}</a>
                            </div>
                            <div class="worktime__item-div-start-work">
                                <p class="worktime__itme-p">{{ \Carbon\Carbon::parse($worktime['start_work'])->format('H:i:s') }}</p>
                            </div>
                            <div class="worktime__item-div-end-work">
                                @if (!is_null($worktime['end_work']))
                                <p class="worktime__itme-p">{{ \Carbon\Carbon::parse($worktime['end_work'])->format('H:i:s') }}</p>
                                @endif
                            </div>
                            <div class="worktime__item-div-break-duration">
                                <p class="worktime__itme-p">{{ $worktime['break_duration'] }}</p>
                            </div>
                            <div class="worktime__item-div">
                                <p class="worktime__itme-p">{{ $worktime['work_duration'] }}</p>
                            </div>
                            <div class="worktime__item-div">
                                <p class="worktime__itme-p"></p>
                            </div>
                        </td>
                    </form>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="paginate">
            {{ $worktimes->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

<footer class=" footer">
    <div class="footer__inner">
        <div class="footer-utilities">
            <a class="footer__logo" href="/attendance">
                Atte,inc.
            </a>
        </div>
    </div>
</footer>

@endsection