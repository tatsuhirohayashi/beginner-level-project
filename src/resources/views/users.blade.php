@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('content')

<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="header__logo" href="/users">
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
    <div class="users__content">
        <div class="users__heading">
            <h2>ユーザー一覧</h2>
        </div>
        <div class="users-table">
            <table class="users__inner">
                <tr class="users__row">
                    <th class="users__header">
                        <div class="users__header-div">名前</div>
                        <div class="users__header-div">メールアドレス</div>
                    </th>
                </tr>
                @foreach ($users as $user)
                <tr class="users__row">
                    <form class="form-worktime" action="" method="get">
                        <td class="users__item">
                            <div class="users__item-div-name">
                                <a href="{{ route('users.show', $user['id']) }}" class="users__itme-a">{{ $user['name'] }}</a>
                            </div>
                            <div class="users__item-div-email">
                                <p class="users__itme-p">{{ $user['email'] }}</p>
                            </div>
                        </td>
                    </form>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="paginate">
            {{ $users->appends(request()->query())->links('vendor.pagination.custom') }}
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