<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function records()
    {
        return $this->hasMany(Record::class);
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount('records', 'followings', 'followers', 'bookmarks');
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    /**
     * このユーザをフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // フォロー済み、または、自分自身の場合は何もしない
            return false;
        } else {
            // 上記以外はフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    /**
     * $userIdで指定されたユーザをアンフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function unfollow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // フォロー済み、かつ、自分自身でない場合はフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 上記以外の場合は何もしない
            return false;
        }
    }

    /**
     * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
     *
     * @param  int  $userId
     * @return bool
     */
    public function is_following($userId)
    {
        // フォロー中ユーザの中に $userIdのものが存在するか
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_records()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Record::whereIn('user_id', $userIds);
    }
    
    public function bookmarks()
    {
        return $this->belongsToMany(Record::class, 'bookmarks', 'user_id', 'record_id')->withTimestamps();
    }
    
    public function bookmark_users()
    {
        return $this->belongsToMany(Record::class, 'bookmarks', 'record_id', 'user_id')->withTimestamps();
    }
    
    public function bookmark($recordId)
    {
        
        $exist = $this->is_bookmarks($recordId);
        
        //$its_me = $this->id == $userId;

        if ($exist) {
            return false;
        } else {
            
            $this->bookmarks()->attach($recordId);
            return true;
        }
    }
    
    public function unbookmark($recordId)
    {
        $exist = $this->is_bookmarks($recordId);
        
        //$its_me = $this->id == $recordId;

        if ($exist) {
            $this->bookmarks()->detach($recordId);
            return true;
        } else {
            return false;
        }
    }
    
    public function is_bookmarks($recordId)
    {
        
        return $this->bookmarks()->where('record_id', $recordId)->exists();
    }
    
    public function feed_bookmark_records()
    {
        
        $recordIds = $this->bookmarks()->pluck('records.id')->toArray();
        
        $recordIds[] = $this->id;
        
        return Record::whereIn('records_id', $recordIds);
    }
}
