@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Quản lý Đăng ký Đề tài</h2>

    <!-- Hiển thị thông báo thành công hoặc lỗi -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>ID Đơn</th>
                        <th>Sinh viên</th>
                        <th>Đề tài đăng ký</th>
                        <th>Trạng thái hiện tại</th>
                        <th>Xét duyệt & Ghi chú (Log)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                    <tr>
                        <td>{{ $reg->id }}</td>
                        <td>{{ $reg->student->student_code ?? 'N/A' }}</td>
                        <td>{{ $reg->topic->title ?? 'N/A' }}</td>
                        
                        <!-- Cột: Trạng thái hiện tại (Đổi màu Badge) -->
                        <td>
                            @if($reg->status == 'Đã duyệt')
                                <span class="badge bg-success">{{ $reg->status }}</span>
                            @elseif($reg->status == 'Từ chối')
                                <span class="badge bg-danger">{{ $reg->status }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $reg->status }}</span>
                            @endif
                        </td>
                        
                        <!-- Cột: Xét duyệt & Ghi chú -->
                        <td>
                            @php
                                $hasScore = false;
                                // Chỉ kiểm tra điểm nếu đơn đã được duyệt
                                if ($reg->status == 'Đã duyệt') {
                                    $assignment = \App\Models\TopicAssignment::where('topic_id', $reg->topic_id)->first();
                                    if ($assignment) {
                                        $hasScore = \App\Models\EvaluationScore::where('topic_assignment_id', $assignment->id)->exists();
                                    }
                                }
                            @endphp

                            @if($hasScore)
                                <!-- KHÓA FORM: Nếu đã có điểm, chỉ hiện nhãn -->
                                <span class="badge bg-secondary mb-2" style="font-size: 13px; padding: 7px;">🔒 Đã có điểm (Khóa)</span>
                            @else
                                <!-- MỞ FORM: Nếu chưa có điểm, hiện Form đổi trạng thái -->
                                <form action="{{ route('admin.topic_registrations.update_status', $reg->id) }}" method="POST" style="display: flex; gap: 10px; margin-bottom: 8px;">
                                    @csrf
                                    @method('PUT')
                                    
                                    <select name="status" class="form-select" style="width: 150px;" required>
                                        <option value="Chờ duyệt" @selected($reg->status == 'Chờ duyệt')>Chờ duyệt</option>
                                        <option value="Đã duyệt" @selected($reg->status == 'Đã duyệt')>Đã duyệt</option>
                                        <option value="Từ chối" @selected($reg->status == 'Từ chối')>Từ chối</option>
                                    </select>

                                    <input type="text" name="note" class="form-control" placeholder="Lý do (nếu từ chối)..." style="width: 200px;">
                                    
                                    <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                                </form>
                            @endif
                            
                            <!-- BẮT ĐẦU CHỖ VỪA ĐƯỢC CHÈN THÊM (Luôn hiển thị) -->
                            <div class="d-flex gap-2 mt-2">
                                <!-- Nút gọi Modal Lịch sử (Chuẩn Bootstrap 5) -->
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#logModal-{{ $reg->id }}">
                                    🔍 Xem lịch sử
                                </button>

                                <!-- Nút Xóa (Kèm cảnh báo xác nhận) -->
                                <form action="{{ route('admin.topic_registrations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn này không? Mọi lịch sử duyệt sẽ bị xóa sạch!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        🗑️ Xóa
                                    </button>
                                </form>
                            </div>
                            <!-- KẾT THÚC CHỖ VỪA ĐƯỢC CHÈN THÊM -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- ĐẶT TOÀN BỘ MODAL Ở ĐÂY, NGOÀI THẺ TABLE -->
<!-- ========================================== -->
@foreach($registrations as $reg)
    <div class="modal fade" id="logModal-{{ $reg->id }}" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Lịch sử duyệt đơn #{{ $reg->id }}</h5>
                    <!-- Nút X tắt Modal (Chuẩn Bootstrap 5) -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Thời gian</th>
                                <th>Trạng thái cũ</th>
                                <th>Trạng thái mới</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reg->statusLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td><span class="badge bg-secondary">{{ $log->old_status ?? 'Mới tạo' }}</span></td>
                                    <td><span class="badge bg-primary">{{ $log->new_status }}</span></td>
                                    <td>{{ $log->note ?? 'Không có' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Chưa có lịch sử thay đổi nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Nút Đóng Modal (Chuẩn Bootstrap 5) -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Chèn cứng thư viện JS Bootstrap 5 vào cuối file để fix lỗi Modal không chạy -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection