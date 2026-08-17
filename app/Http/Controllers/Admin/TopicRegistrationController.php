<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\TopicRegistration;
use App\Models\StatusLog;
use App\Models\Topic; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicRegistrationController extends Controller
{   
    public function index()
    {
        $registrations = TopicRegistration::with(['student', 'topic', 'statusLogs'])->orderBy('created_at', 'desc')->get();
        return view('admin.topic_registrations.index', compact('registrations'));
    }

    public function updateStatus(Request $request, TopicRegistration $registration)
    {
        $request->validate([
            'status' => 'required|string|in:Chờ duyệt,Đã duyệt,Từ chối',
            'note' => 'nullable|string'
        ]);

        $oldStatus = $registration->status;
        $newStatus = $request->status;
        
        $topic = Topic::find($registration->topic_id);

        // --- BƯỚC 1: CHẶN DUYỆT LỐ ---
        if ($topic && $newStatus === 'Đã duyệt' && $oldStatus !== 'Đã duyệt') {
            $approvedCount = TopicRegistration::where('topic_id', $topic->id)
                                                ->where('status', 'Đã duyệt')
                                                ->count();
            
            if ($approvedCount >= $topic->max_students) {
                return back()->with('error', 'Lỗi Nghiệp Vụ: Đề tài "' . ($topic->name ?? $topic->id) . '" đã đạt giới hạn tối đa (' . $topic->max_students . ' sinh viên). KHÔNG THỂ DUYỆT THÊM!');
            }
        }

        // --- BƯỚC 2: CHẶN THAY ĐỔI NẾU ĐÃ CÓ ĐIỂM (Khóa tuyệt đối) ---
        $assignment = \App\Models\TopicAssignment::where('topic_id', $registration->topic_id)->first();
        if ($assignment) {
            $hasScore = \App\Models\EvaluationScore::where('topic_assignment_id', $assignment->id)->exists();
            
            // Nếu đã có điểm, CHẶN TẤT CẢ mọi thao tác bấm Lưu (dù là đổi trạng thái hay đổi ghi chú)
            if ($hasScore) {
                return back()->with('error', 'Lỗi: Đề tài này đã được chấm điểm. Hồ sơ đã bị khóa cứng và không thể chỉnh sửa!');
            }
        }

        // --- BƯỚC 3: CẬP NHẬT TRẠNG THÁI VÀ XỬ LÝ LOGIC ĐÓNG/MỞ ĐỀ TÀI ---
        if ($oldStatus !== $newStatus) {
            DB::transaction(function () use ($registration, $oldStatus, $newStatus, $request, $topic) {
                
                // 1. Cập nhật trạng thái mới cho đơn
                $registration->update(['status' => $newStatus]);

                // 2. Tự động ghi log
                StatusLog::create([
                    'topic_registration_id' => $registration->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'note' => $request->note
                ]);
                
                // 3. TỰ ĐỘNG ĐÓNG HOẶC MỞ LẠI ĐỀ TÀI
                if ($topic) {
                    $currentApproved = TopicRegistration::where('topic_id', $topic->id)
                                                        ->where('status', 'Đã duyệt')
                                                        ->count();
                    
                    // Sửa lỗi SQL Data truncated: Sử dụng 'Closed' và 'Open'
                    if ($currentApproved >= $topic->max_students && $topic->status !== 'Closed') {
                        $topic->update(['status' => 'Closed']);
                    } 
                    elseif ($currentApproved < $topic->max_students && $topic->status === 'Closed') {
                        $topic->update(['status' => 'Open']);
                    }
                }
            });
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn và kiểm tra giới hạn đề tài thành công!');
    }
    
    // Xóa đơn đăng ký
    public function destroy($id)
    {
        $registration = TopicRegistration::findOrFail($id);

        \App\Models\StatusLog::where('topic_registration_id', $id)->delete();
        $registration->delete();

        return back()->with('success', 'Đã xóa đơn đăng ký và lịch sử liên quan thành công!');
    }
}