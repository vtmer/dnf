<?php namespace App\Models\Backend\blog;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;
use App\Models\Backend\User;
use App\Models\Backend\blog\tag;


class Tag extends BaseModel {



   /*
    *属性：表名
    */
    protected $table = 'blog_tag';


    protected $fillable = ['tag','creator','updater','updated_at','created_at'];

/*
|------------------------------------------------
|根据id删除栏目
|同时删除该栏目下的文章
|--------------------------------------------------
*/

   public static function deleteById($id)
   {
        return static::destroy($id);
   }

/*
|------------------------------------------------j
|创建新的栏目
|自动填充创建人
|------------------------------------------------
 */
    public static function createOneTag($data)
    {
        $user = Auth::user();
        return static::create([
            'creator' => $user->realname,
            'tag' => $data['tag'],
            'updater'  => $data['updater'],
            'updated_at' => time(),
            'created_at' => time(),

        ]);
    }
   /*
    * 标签下的文章
    * 多对多关系
    */
    public function articles()
    {
    	return $this->belongsToMany('App\Models\Backend\blog\Article');
    }
}
