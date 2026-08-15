<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    use HasFactory;

    protected $fillable = ['topic_registration_id', 'old_status', 'new_status', 'note'];

    public function topicRegistration()
    {
        return $this->belongsTo(TopicRegistration::class);
    }
}