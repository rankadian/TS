<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfesiModel extends Model
{
    protected $table = 'profesi';
    protected $primaryKey = 'id_profesi';
    protected $fillable = ['category_id', 'nama_profesi'];

    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'category_id');
    }
}
