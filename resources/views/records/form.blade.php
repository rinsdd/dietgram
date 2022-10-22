
    <div class="form-group">
        <form action="{{ action('RecordsController@store') }}" method="post" enctype="multipart/form-data">
            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2']) !!}
                    <!-- アップロードフォームの作成 -->
            <input type="file" name="image">
            {{ csrf_field() }}
            {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
        </form>
        
        {{-- {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!} --}}
    </div>
