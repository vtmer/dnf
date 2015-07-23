<?php namespace App\Models\Backend\blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\BaseModel;


class Article extends BaseModel {
    /**
     * 软删除
     * @var boolean
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    /*
    |---------------------------------------------------------------------------
    |模型关系
    |----------------------------------------------------------------------------
     */
    protected $table = 'blog_articles';

      /*
       *批量赋值
       */
      protected $fillable =['title','category_id','updater','author','source','description','content','draft','img_URL','scroll','created_at','updated_at','deleted_at',

	];

   /*
    *创建新的文章
    *
    */
      public static function createOneArticle($data)
      {
          return static::create([
              'title' => $data['title'],
              'category_id'=>$data['category_id'],
              'updater'=> $data['updater'],
              'author'=> $data['author'],
              'description'=>$data['description'],
              'source'=> $data['source'],
              'content'=>$data['content'],
              'draft' => $data['draft'],
              'img_URL' => $data['img_URL'],
              'create_at'=> time(),
              'update_at'=> time(),
          ]);
      }

   /**
     *文章栏目
     *一对多关系
     */

    public function category()
    {
        return $this->belongsTo('App\Models\Backend\blog\Category','category_id','id');
    }

    /**
      * article_tag field declaration
      *
      * @return object;
      */

    public function article_tag()
    {
        return $this->hasMany('App\Models\Backend\blog\ArticleTag','id','article_id');
    }

    /*
     *文章和标签的多对多关系
     *
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Backend\blog\Tag');
    }


}



