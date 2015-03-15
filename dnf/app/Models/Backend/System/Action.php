<?php namespace App\Models\Backend\System;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\User;
use App\Models\Backend\BaseModel;

class Action extends BaseModel {

    protected $table = "admin_actions";

    protected $fillable = ['uid', 'uname', 'type', 'title', 'description',
                            'updated_at', 'created_at'];

    /**
     * 关闭日期转换
     */
    public function getDates()
    {
        return array();
    }

    /**
     * 新建一个动态
     *
     * @param int $type 动态类型
     * @param string $title 动态标题
     * @param string $description 动态简介
     * @return boolean
     */
    public static function createOneAction($type, $title, $description = null)
    {
        $user = Auth::user();
        return static::create([
            'uid' => $user->id,
            'uname' => $user->realname,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'updated_at' => time(),
            'created_at' => time(),
        ]);
    }

    /**
     * 关联用户
     * 一对一
     *
     * @return user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Backend\User', 'uid', 'id');
    }
}
