{{-- @if (Auth::id() != $user->id) --}}
    @if (Auth::user()->is_bookmarks($record->id))
        {{-- お気に入りを削除するボタンのフォーム --}}
                        {!! Form::open(['route' => ['bookmarks.unbookmark', $record->id], 'method' => 'delete']) !!}
                        {!! Form::submit('ブックマーク削除', ['class' => "btn btn-success btn-sm"]) !!}
                        {!! Form::close() !!}
                        @else
                            {{-- お気に入りボタンのフォーム --}}
                            {!! Form::open(['route' => ['bookmarks.bookmark', $record->id]]) !!}
                            {!! Form::submit('ブックマーク', ['class' => "btn btn-light btn-sm"]) !!}
                            {!! Form::close() !!}
    @endif
{{--@endif--}}