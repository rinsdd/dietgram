@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                {{-- ユーザ情報 --}}
                @include('users.card')
            </aside>
            <div class="col-sm-8">
                {{-- 投稿フォーム --}}
                @include('records.form')
                {{-- 投稿一覧 --}}
                @include('records.records')
            </div>
        </div>
    @else
    <div class="center jumbotron">
        <div class="box">
        <div class="thumbnail text-center">
            <h1>美味しいダイエットご飯を見つけよう</h1>
            {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route('signup.get', '会員登録', [], ['class' => 'btn btn-lg btn-primary']) !!}
            {!! link_to_route('login', 'ログイン', [], ['class' => 'btn btn-lg btn-secondary']) !!}
        </div>
    </div>
    </div>
    <div class="center jumbotron-fluid">
        <div class="intro">
            <p class="fs-3">1、ダイエットご飯の写真を投稿する</p>
            <p class="fs-3">2、他のユーザーのダイエットご飯を見ましょう</p>
            <p class="fs-3">3、同じ料理に飽きてしまう時、他のユーザーの投稿からモチベーションを取り戻しましょう</p>
        </div>
    </div>
    @endif
@extends('commons.footer')
@endsection        
        

