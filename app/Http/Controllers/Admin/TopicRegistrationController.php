<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\TopicRegistration;
use App\Models\StatusLog;
use App\Models\Topic; // Đã thêm import Topic vào đây để không bị lỗi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicRegistrationController extends Controller
{   
    public function index()
    {
        // Thêm 'statusLogs' vào hàm with()
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

        // --- BẮT ĐẦU CHÈN LOGIC KIỂM TRA SỐ LƯỢNG Ở ĐÂY ---
        // Nếu cậu (Admin) định duyệt đơn này, hệ thống sẽ phải đếm trước
        if ($newStatus === 'Đã duyệt' && $oldStatus !== 'Đã duyệt') {
            // Đếm số lượng đơn của đề tài này đã được duyệt trước đó
            $approvedCount = TopicRegistration::where('topic_id', $registration->topic_id)
                                              ->where('status', 'Đã duyệt')
                                              ->count();
            
            // Lấy thông tin đề tài để biết giới hạn (max_students)
            $topic = Topic::find($registration->topic_id);

            // Kiểm tra giới hạn: Nếu số đơn đã duyệt bằng hoặc lớn hơn số lượng cho phép thì chặn ngay
            if ($topic && $approvedCount >= $topic->max_students) {
                return back()->with('error', 'Lỗi Nghiệp Vụ: Đề tài "' . $topic->title . '" đã đạt giới hạn tối đa (' . $topic->max_students . ' sinh viên). KHÔNG THỂ DUYỆT THÊM!');
            }
        }
        // --- KẾT THÚC LOGIC KIỂM TRA ---

        // Chỉ ghi log nếu trạng thái thực sự bị thay đổi
        if ($oldStatus !== $newStatus) {
            DB::transaction(function () use ($registration, $oldStatus, $newStatus, $request) {
                
                // 1. Cập nhật trạng thái mới cho đơn
                $registration->update(['status' => $newStatus]);

                // 2. Tự động ghi log
                StatusLog::create([
                    'topic_registration_id' => $registration->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'note' => $request->note
                ]);
                
            });
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đề tài và lưu log thành công!');
    }
    
    // Xóa đơn đăng ký
    public function destroy($id)
    {
        $registration = TopicRegistration::findOrFail($id);

        // Xóa tất cả lịch sử log liên quan trước để tránh lỗi khóa ngoại (Foreign Key Constraint) trong Database
        \App\Models\StatusLog::where('topic_registration_id', $id)->delete();
        
        // Sau đó mới xóa đơn đăng ký
        $registration->delete();

        return back()->with('success', 'Đã xóa đơn đăng ký và lịch sử liên quan thành công!');
    }
}