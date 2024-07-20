@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="header__logo" href="/login">
                Atte
            </a>
        </div>
    </div>
</header>

<div class="body">
    <div class="login__content">
        <div class="login__heading">
            <h2>ログイン</h2>
        </div>
        <div class="login__content-ttl">
            <form class="form" action="/login" method="post">
                @csrf
                <div class="form__group">
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" />
                        </div>
                        <div class="form__error">
                            @error('email')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password" placeholder="パスワード" value="{{ old('password') }}" />
                        </div>
                        <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">ログイン</button>
                </div>
                <div class="form__link">
                    <p class="form__link-p">アカウントをお持ちでない方はこちらから</p>
                    <a class="form__link-a" href="/register">会員登録</a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="footer__inner">
        <div class="footer-utilities">
            <a class="footer__logo" href="/login">
                Atte,inc.
            </a>
        </div>
    </div>
</footer>

@endsection