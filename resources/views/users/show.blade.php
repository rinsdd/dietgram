@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            {{-- ユーザ情報 --}}
            @include('users.card')
        </aside>
        <div class="col-sm-8">
            {{-- タブ --}}
            @include('users.navtabs')
            @if (Auth::id() == $user->id)
                {{-- 投稿フォーム --}}
                @include('records.form')
            @endif
            {{-- 投稿一覧 --}}
            <h2>今までのダイエットご飯</h2>
            @include('records.records')

        </div>
    </div>
    @extends('commons.footer') 
@endsection