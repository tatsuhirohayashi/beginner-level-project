@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="header__logo" href="/register">
                Atte
            </a>
        </div>
    </div>
</header>

<div class="body">
    <div class="register__content">
        <div class="register__heading">
            <h2>会員登録</h2>
        </div>
        <div class="register__content-ttl">
            <form class="form" action="/register" method="post">
                @csrf
                <div class="form__group">
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="name" placeholder="名前" value="{{ old('name') }}" />
                        </div>
                        <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
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
                <div class="form__group">
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password_confirmation" placeholder="確認用パスワード" value="{{ old('password_confirmation') }}" />
                        </div>
                        <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">会員登録</button>
                </div>
                <div class="form__link">
                    <p class="form__link-p">アカウントをお持ちの方はこちらから</p>
                    <a class="form__link-a" href="/login">ログイン</a>
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