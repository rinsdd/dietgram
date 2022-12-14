@if (count($records) > 0)
    <ul class="list-unstyled">
        @foreach ($records as $record)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($record->user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $record->user->name, ['user' => $record->user->id]) !!}
                        <span class="text-muted">posted at {{ $record->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($record->content)) !!}</p>
                        @if ($record->image_path)
                        {{--画像を表示 -->--}}
                        <img src="{{ $record->image_path }}">
                         @endif
                        @include('bookmarks.bookmark_button')
                    </div>
                    <div>
                        @if (Auth::id() == $record->user_id)
                            {{-- 投稿削除ボタンのフォーム --}}
                            {!! Form::open(['route' => ['records.destroy', $record->id], 'method' => 'delete']) !!}
                                {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $records->links() }}
@endif