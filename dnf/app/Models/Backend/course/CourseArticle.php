<?php namespace App\Models\Backend\course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\BaseModel;


class CourseArticle extends BaseModel {
    /**
     * 软删除
     * @var boolean
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $table = 'course_articles';

      /*
       *批量赋值
       */
      protected $fillable =['title','course_id','updater','author','content','draft','view','created_at','updated_at','deleted_at',];

         /*
    *创建新的文章
    *
    */
      public static function createOneArticle($data)
      {
          return static::create([
              'title' => $data['title'],
              'course_id'=>$data['course_id'],
              'updater'=> $data['updater'],
              'author'=> $data['author'],
              'content'=>$data['content'],
              'draft' => $data['draft'],
              'created_at'=> time(),
              'updated_at'=> time(),
          ]);
      }

   /**
     *文章栏目
     *一对多关系
     */

    public function course()
    {
        return $this->belongsTo('App\Models\Backend\course\Course','course_id','id');
    }

    }
