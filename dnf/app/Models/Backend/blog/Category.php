<?php namespace App\Models\Backend\blog;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;
use App\Models\Backend\User;
use App\Models\Backend\blog\category;

class Category extends BaseModel{


    protected $table = 'blog_categories';

    protected $fillable = ['category','creator','updater','update_at','create_at'];



/*
|----------------------------------------
|根据id删除栏目
|同时删除该栏目下的文章
|---------------------------------------
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
    public static function createOneCategory($data)
    {
        $user = Auth::user();
        return static::create([
            'creator' => $user->realname,
            'category' => $data['category'],
            'updater'  => $data['updater'],
            'updated_at' => time(),
            'created_at' => time(),

        ]);
    }

/*
|------------------------------------------------
| 模型关系
|------------------------------------------------
*/

   /**
    *分类下的文章
    *一对多
    *
    */
 public function articles()
    {
        return $this->hasMany('App\Models\Backend\blog\Article','id','category_id');
    }
}
