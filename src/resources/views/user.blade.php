@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')

<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="header__logo" href="{{ url('/user', ['id' => $user->id]) }}">
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
    <div class="user__content">
        <div class="user__heading">
            <h2>{{ $user['name'] }}さん</h2>
        </div>
        <div class="user-table">
            <table class="user__inner">
                <tr class="user__row">
                    <th class="user__header">
                        <div class="user__header-div">日付</div>
                        <div class="user__header-div">勤務開始</div>
                        <div class="user__header-div">勤務終了</div>
                        <div class="user__header-div">休憩時間</div>
                        <div class="user__header-div">勤務時間</div>
                        <div class="user__header-div"></div>
                    </th>
                </tr>
                @foreach ($worktimes as $worktime)
                <tr class="user__row">
                    <form class="form-worktime" action="" method="get">
                        <td class="user__item">
                            <div class="user__item-div-date">
                                <p class="user__itme-p">{{ \Carbon\Carbon::parse($worktime['start_work'])->format('m月d日') }}</p>
                            </div>
                            <div class="user__item-div-start-work">
                                <p class="user__itme-p">{{ \Carbon\Carbon::parse($worktime['start_work'])->format('H:i:s') }}</p>
                            </div>
                            <div class="user__item-div-end-work">
                                <p class="user__itme-p">{{ \Carbon\Carbon::parse($worktime['end_work'])->format('H:i:s') }}</p>
                            </div>
                            <div class="user__item-div-break-duration">
                                <p class="user__itme-p">{{ $worktime['break_duration'] }}</p>
                            </div>
                            <div class="user__item-div-work-duration">
                                <p class="user__itme-p">{{ $worktime['work_duration'] }}</p>
                            </div>
                            <div class="user__item-div">
                                <p class="user__itme-p"></p>
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
            <a class="footer__logo" href="{{ url('/user', ['id' => $user->id]) }}">
                Atte,inc.
            </a>
        </div>
    </div>
</footer>

@endsection