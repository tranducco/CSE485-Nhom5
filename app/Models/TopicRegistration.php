<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicRegistration extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'topic_id', 'status'];

    // Kết nối về sinh viên
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Kết nối về đề tài (Tuân thủ khóa topic_id của nhóm)
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // Kết nối tới bảng log
    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class);
    }
}