<?php namespace App\Models\Backend\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\BaseModel;

class Product extends BaseModel {
    /**
     * 软删除
     * @var boolean
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
  

   protected $table = 'product';

      /*
       *批量赋值
       */
      protected $fillable =['name','img_URL','holder','url','description','created_at','updated_at','deleted_at'];

  }
