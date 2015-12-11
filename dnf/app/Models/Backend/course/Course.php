<?php namespace App\Models\Backend\course;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;
use App\Models\Backend\User;
use App\Models\Backend\course\course;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends BaseModel{


    use SoftDeletes;
    protected $table = 'course';

    protected $fillable = ['name','creator','updater','updated_at','created_at'];

    /*
|------------------------------------------------
|创建新的教程
|自动填充创建人
|------------------------------------------------
 */
    public static function createOneCourse($data)
    {
        $user = Auth::user();
        return static::create([
            'creator' => $user->realname,
            'name' => $data['name'],
            'updater'  => $data['updater'],
            'updated_at' => time(),
            'created_at' => time(),

        ]);
    }

   public static function deleteById($id)
   {
       return delete($id);
   }

/*
|------------------------------------------------
| 模型关系
|------------------------------------------------
*/

   /**
    *教程下的文章
    *一对多
    *
    */
 public function CourseArticles()
    {
        return $this->hasMany('App\Models\Backend\course\CourseArticle','id','course_id');
    }
}

