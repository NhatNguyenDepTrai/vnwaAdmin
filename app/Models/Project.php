<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id_category_project', 'url_bg', 'url_avatar', 'url_avatar_mobile', 'name', 'slug', 'desc', 'content', 'feedback_name', 'feedback_content', 'meta_title', 'meta_image', 'meta_desc'];
    public function listImages()
    {
        return $this->hasMany(ListImage::class, 'id_tb')->where('tb', 'projects');
    }
    public function categoryProject()
    {
        return $this->belongsTo(CategoryProject::class, 'id_category_project');
    }
}
