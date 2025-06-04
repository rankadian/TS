<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';     
    protected $fillable = ['category_name'];    

    public $timestamps = true;                   

    public function profesi()
    {
        return $this->hasMany(ProfesiModel::class, 'category_id', 'category_id');  
    }
}
