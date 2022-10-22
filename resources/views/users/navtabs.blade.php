<ul class="nav nav-tabs nav-justified mb-3">
    {{-- ユーザ詳細タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            記録
            <span class="badge badge-secondary">{{ $user->records_count }}</span>
        </a>
    </li>
    {{-- フォロー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.followings', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.followings') ? 'active' : '' }}">
            フォロー中
            <span class="badge badge-secondary">{{ $user->followings_count }}</span>
        </a>
    </li>
    {{-- フォロワー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.followers', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.followers') ? 'active' : '' }}">
            フォローワー
            <span class="badge badge-secondary">{{ $user->followers_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.bookmarks', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.bookmarks') ? 'active' : '' }}">
            ブックマーク
            <span class="badge badge-secondary">{{ $user->bookmarks_count }}</span>
        </a>
    </li>
</ul>