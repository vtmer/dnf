<?php namespace App\Models\Backend\blog;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;


class ArticleTag extends BaseModel{

      /**
       *属性：表名
       */
    protected $table = 'article_tag';

       /**
        * the attribute that allow to set value together
        *
        *@var array
        *
        */
    protected $fillable = ['article_id','tag_id'];


    /**
     *
     *@ var string
     */

    public $timestamps = false;

}
