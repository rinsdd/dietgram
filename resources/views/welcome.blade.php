@extends('layouts.app')

@section('content')
    <div class="center jumbotron">
        <div class="box">
        <div class="thumbnail text-center">
            <h1>美味しいダイエットご飯を見つけよう</h1>
            {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route('signup.get', '会員登録', [], ['class' => 'btn btn-lg btn-primary']) !!}
            <button type="button" class="btn btn-secondary">ログイン</button>
        </div>
    </div>
    <div class="center jumbotron-fluid">
        <div class="intro">
            <p class="fs-3">.１、ダイエットご飯の写真を投稿する</p>
            <p class="fs-3">.２、他のユーザーのダイエットご飯を見ましょう</p>
            <p class="fs-3">.3、同じ料理に飽きてしまう時、他のユーザーの投稿からモチベーションを取り戻しましょう</p>
        </div>
    </div>
</div>
@endsection        
        
  @extends('commons.footer')      

