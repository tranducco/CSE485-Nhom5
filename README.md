# HỆ THỐNG QUẢN LÝ ĐỒ ÁN TỐT NGHIỆP

## 1. Giới thiệu đề tài

**Hệ thống Quản lý Đồ án** là một ứng dụng Web được xây dựng nhằm số hóa và tự động hóa quy trình quản lý, đăng ký và đánh giá đồ án/bài tập lớn tại trường Đại học.

Dự án giải quyết các bài toán về phân quyền chặt chẽ, đảm bảo tính toàn vẹn dữ liệu và tạo ra một luồng công việc (**workflow**) khép kín giữa 3 nhóm đối tượng chính:

* **Quản trị viên (Admin):** Khởi tạo danh mục dữ liệu gốc như người dùng, chuyên ngành, đề tài. Chịu trách nhiệm xét duyệt đơn đăng ký của sinh viên, kiểm soát số lượng giới hạn của từng đề tài và phân công giảng viên hướng dẫn.
* **Giảng viên (Lecturer):** Theo dõi danh sách sinh viên được phân công. Quản lý, xem xét tài liệu báo cáo tiến độ (**milestones**) của sinh viên và thực hiện đánh giá, chấm điểm tổng kết.
* **Sinh viên (Student):** Theo dõi danh sách đề tài đang mở, thực hiện đăng ký đề tài. Cập nhật link tài liệu báo cáo theo từng mốc tiến độ quy định và tra cứu điểm số, nhận xét từ giảng viên.

---

## 2. Tính năng nổi bật

### 2.1. Phân quyền bảo mật đa lớp

* Sử dụng **Middleware** để kiểm soát luồng truy cập phía Server.
* Phân quyền theo 3 Role:

  * `Admin`
  * `Lecturer`
  * `Student`
* Ngăn chặn người dùng truy cập trái phép vào các URL hoặc chức năng không thuộc quyền hạn.

### 2.2. Quản lý giới hạn đề tài thông minh

* Tự động đếm số lượng sinh viên đã được duyệt vào từng đề tài.
* Kiểm soát số lượng sinh viên tối đa thông qua thuộc tính `max_students`.
* Tự động xác định trạng thái đề tài khi đã đạt giới hạn đăng ký.
* Hạn chế tình trạng đăng ký vượt quá số lượng cho phép.

### 2.3. Quản lý tiến độ đồ án

* Sinh viên có thể cập nhật đường dẫn tài liệu theo từng mốc tiến độ.
* Mỗi milestone có thể được quản lý riêng biệt.
* Giảng viên có thể theo dõi toàn bộ quá trình thực hiện đồ án.
* Hỗ trợ giảng viên xem xét tài liệu trước khi thực hiện đánh giá và chấm điểm.

### 2.4. Đảm bảo tính toàn vẹn dữ liệu

* Khi giảng viên đã tiến hành nhập điểm, dữ liệu liên quan có thể được **khóa**.
* Hạn chế việc chỉnh sửa hồ sơ đăng ký sau khi quá trình đánh giá đã bắt đầu.
* Ngăn chặn các thay đổi không hợp lệ đối với dữ liệu đã được chốt.

### 2.5. Quản lý đề tài

* Quản lý danh sách đề tài.
* Quản lý mã đề tài và tên đề tài.
* Quản lý chuyên ngành phù hợp với đề tài.
* Thiết lập số lượng sinh viên tối đa cho từng đề tài.
* Theo dõi trạng thái đăng ký của đề tài.

### 2.6. Quản lý sinh viên

* Quản lý thông tin sinh viên.
* Liên kết sinh viên với tài khoản đăng nhập.
* Liên kết sinh viên với chuyên ngành.
* Quản lý thông tin đăng ký đồ án.
* Theo dõi trạng thái đăng ký và quá trình thực hiện đồ án.

### 2.7. Quản lý giảng viên

* Quản lý thông tin giảng viên.
* Phân công giảng viên hướng dẫn cho sinh viên.
* Theo dõi danh sách sinh viên được phân công.
* Thực hiện đánh giá và chấm điểm đồ án.

### 2.8. Đánh giá và chấm điểm

* Giảng viên có thể nhập điểm đánh giá cho sinh viên.
* Lưu trữ điểm số và nhận xét.
* Sinh viên có thể tra cứu kết quả đánh giá.
* Dữ liệu đánh giá được kiểm soát nhằm đảm bảo tính toàn vẹn.

---

## 3. Công nghệ sử dụng

| Thành phần             | Công nghệ                                       |
| ---------------------- | ----------------------------------------------- |
| **Backend**            | PHP 8.x, Laravel Framework                      |
| **Frontend**           | HTML5, CSS3, Blade Template Engine, Bootstrap 5 |
| **Database**           | MySQL                                           |
| **Authentication**     | Laravel Authentication                          |
| **Authorization**      | Role-Based Access Control (RBAC)                |
| **Password Security**  | Bcrypt                                          |
| **Web Server**         | XAMPP / Laravel Artisan Server                  |
| **Dependency Manager** | Composer                                        |

---

## 4. Yêu cầu hệ thống

Để cài đặt và chạy dự án, máy tính cần có các phần mềm sau:

* **PHP >= 8.1**
* **MySQL**
* **Composer**
* **XAMPP** hoặc phần mềm tương đương
* Trình duyệt Web hiện đại như:

  * Google Chrome
  * Microsoft Edge
  * Mozilla Firefox

Có thể tải các công cụ cần thiết tại:

* [XAMPP](https://www.apachefriends.org/index.html)
* [Composer](https://getcomposer.org/)

---

# 5. Hướng dẫn cài đặt và cấu hình

## Bước 1: Clone mã nguồn

Clone mã nguồn dự án từ GitHub về máy tính:

```bash
git clone <repository-url>
```

Di chuyển vào thư mục dự án:

```bash
cd <project-folder>
```

---

## Bước 2: Cài đặt thư viện

Mở Terminal tại thư mục gốc của dự án và chạy:

```bash
composer install
```

Sau khi cài đặt hoàn tất, Laravel sẽ có đầy đủ các thư viện cần thiết trong thư mục `vendor`.

---

## Bước 3: Tạo file `.env`

Sao chép file cấu hình mẫu:

### Windows

```bash
copy .env.example .env
```

### Linux / macOS

```bash
cp .env.example .env
```

Sau đó tạo Application Key:

```bash
php artisan key:generate
```

---

## Bước 4: Cấu hình cơ sở dữ liệu

Mở file `.env` và tìm phần cấu hình Database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tlu_project_db
DB_USERNAME=root
DB_PASSWORD=
```

Trong đó:

* `DB_CONNECTION`: Loại cơ sở dữ liệu sử dụng.
* `DB_HOST`: Địa chỉ máy chủ MySQL.
* `DB_PORT`: Cổng MySQL mặc định.
* `DB_DATABASE`: Tên database của dự án.
* `DB_USERNAME`: Tài khoản MySQL.
* `DB_PASSWORD`: Mật khẩu MySQL.

> **Lưu ý:** Cần tạo database rỗng có tên `tlu_project_db` trong phpMyAdmin trước khi thực hiện bước Migration.

---

## Bước 5: Khởi tạo cơ sở dữ liệu

Dự án sử dụng **Laravel Migration** và **Seeder** để tự động tạo cấu trúc database và dữ liệu mẫu.

### Cách A: Migrate và Seed

Đây là cách được khuyến nghị:

```bash
php artisan migrate:fresh --seed
```

Lệnh trên sẽ:

1. Xóa các bảng hiện có.
2. Tạo lại toàn bộ bảng theo các file Migration.
3. Chạy Seeder.
4. Tạo dữ liệu mẫu cho hệ thống.
5. Tạo các tài khoản Demo nếu Seeder của dự án đã được cấu hình.

> **Cảnh báo:** `migrate:fresh` sẽ xóa toàn bộ dữ liệu hiện có trong database. Không sử dụng lệnh này trên database đang chứa dữ liệu quan trọng.

---

### Cách B: Import file SQL

Nếu dự án có cung cấp file `database.sql`, có thể import trực tiếp bằng phpMyAdmin.

Thực hiện:

1. Mở **phpMyAdmin**.
2. Chọn database `tlu_project_db`.
3. Chọn tab **Import**.
4. Chọn file `database.sql`.
5. Nhấn **Import / Thực thi**.
6. Kiểm tra các bảng đã được tạo thành công.

---

## Bước 6: Khởi chạy ứng dụng

Sau khi hoàn thành các bước trên, chạy Laravel Development Server:

```bash
php artisan serve
```

Nếu chạy thành công, Terminal sẽ hiển thị địa chỉ tương tự:

```text
http://127.0.0.1:8000
```

Mở trình duyệt và truy cập:

**http://127.0.0.1:8000**

---

# 6. Tài khoản Demo

Sau khi chạy:

```bash
php artisan migrate:fresh --seed
```

hệ thống sẽ cung cấp các tài khoản mẫu để kiểm tra chức năng phân quyền.

## 6.1. Quản trị viên

| Thông tin    | Giá trị            |
| ------------ | ------------------ |
| **Role**     | Admin              |
| **Email**    | `admin@tlu.edu.vn` |
| **Mật khẩu** | `123456`           |

---

## 6.2. Giảng viên

| Thông tin      | Giá trị         |
| -------------- | --------------- |
| **Role**       | Lecturer        |
| **Email**      | `an@tlu.edu.vn` |
| **Giảng viên** | Nguyễn Văn An   |
| **Mật khẩu**   | `123456`        |

---

## 6.3. Sinh viên

| Thông tin     | Giá trị                   |
| ------------- | ------------------------- |
| **Role**      | Student                   |
| **Email**     | `cotd@student.tlu.edu.vn` |
| **Sinh viên** | Trần Đức Cơ               |
| **Mật khẩu**  | `123456`                  |

> **Lưu ý:** Thông tin tài khoản Demo phụ thuộc vào dữ liệu được định nghĩa trong các Seeder của dự án. Nếu Seeder được thay đổi, thông tin đăng nhập cũng có thể thay đổi.

---

# 7. Quy trình hoạt động của hệ thống

Hệ thống được xây dựng theo quy trình quản lý đồ án gồm các bước chính:

```text
Admin
  │
  ├── Quản lý người dùng
  ├── Quản lý chuyên ngành
  ├── Quản lý đề tài
  │
  ▼
Sinh viên đăng ký đề tài
  │
  ▼
Admin xét duyệt đăng ký
  │
  ▼
Phân công giảng viên hướng dẫn
  │
  ▼
Sinh viên thực hiện đồ án
  │
  ├── Milestone 1
  ├── Milestone 2
  ├── Milestone 3
  └── ...
  │
  ▼
Giảng viên xem xét tiến độ
  │
  ▼
Giảng viên đánh giá & chấm điểm
  │
  ▼
Sinh viên tra cứu kết quả
```

---

# 8. Phân quyền hệ thống

| Chức năng                    | Admin | Lecturer | Student |
| ---------------------------- | :---: | :------: | :-----: |
| Quản lý người dùng           |   ✅   |     ❌    |    ❌    |
| Quản lý chuyên ngành         |   ✅   |     ❌    |    ❌    |
| Quản lý đề tài               |   ✅   |     ❌    |    ❌    |
| Xét duyệt đăng ký            |   ✅   |     ❌    |    ❌    |
| Phân công giảng viên         |   ✅   |     ❌    |    ❌    |
| Xem sinh viên được phân công |   ❌   |     ✅    |    ❌    |
| Quản lý tiến độ              |   ❌   |     ✅    |    ✅    |
| Nộp tài liệu tiến độ         |   ❌   |     ❌    |    ✅    |
| Đánh giá sinh viên           |   ❌   |     ✅    |    ❌    |
| Chấm điểm                    |   ❌   |     ✅    |    ❌    |
| Xem điểm                     |   ❌   |     ❌    |    ✅    |

---

# 9. Cấu trúc thư mục dự án

Cấu trúc cơ bản của dự án Laravel:

```text
project/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── ...
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── resources/
│   └── views/
│       ├── admin/
│       ├── lecturer/
│       ├── student/
│       └── ...
│
├── routes/
│   └── web.php
│
├── public/
│
├── storage/
│
├── .env.example
├── composer.json
└── README.md
```

---

# 10. Bảo mật

Hệ thống áp dụng một số cơ chế bảo mật của Laravel:

* **Authentication:** Xác thực người dùng khi đăng nhập.
* **Authorization:** Kiểm soát quyền truy cập theo Role.
* **Middleware:** Bảo vệ các Route và chức năng yêu cầu quyền hạn.
* **Password Hashing:** Mật khẩu được mã hóa bằng cơ chế Hash của Laravel/Bcrypt.
* **CSRF Protection:** Bảo vệ các Form khỏi các cuộc tấn công Cross-Site Request Forgery.
* **Validation:** Kiểm tra dữ liệu đầu vào trước khi lưu vào cơ sở dữ liệu.
* **Data Integrity:** Sử dụng Foreign Key và các ràng buộc dữ liệu để hạn chế dữ liệu không hợp lệ.

---

# 11. Mục tiêu của hệ thống

Hệ thống được xây dựng nhằm:

* Số hóa quy trình quản lý đồ án.
* Giảm thiểu việc quản lý thủ công bằng giấy tờ hoặc bảng tính.
* Hỗ trợ Admin quản lý tập trung dữ liệu.
* Hỗ trợ giảng viên theo dõi tiến độ sinh viên.
* Giúp sinh viên đăng ký và theo dõi quá trình thực hiện đồ án.
* Tăng tính minh bạch trong quá trình đánh giá và chấm điểm.
* Đảm bảo dữ liệu được quản lý tập trung và nhất quán.

---

# 12. Hướng phát triển

Trong các phiên bản tiếp theo, hệ thống có thể được mở rộng thêm:

* Gửi thông báo tự động cho sinh viên và giảng viên.
* Gửi email khi đăng ký hoặc xét duyệt đề tài.
* Upload trực tiếp file báo cáo thay vì chỉ lưu đường dẫn.
* Dashboard thống kê trực quan.
* Xuất báo cáo sang Excel/PDF.
* Tích hợp biểu đồ theo dõi tiến độ.
* Bổ sung lịch bảo vệ đồ án.
* Quản lý hội đồng chấm bảo vệ.
* Tích hợp hệ thống thông báo theo thời gian thực.

---

# 13. Tác giả

**Dự án:** Hệ thống Quản lý Đồ án Tốt nghiệp

**Đơn vị:** Trường Đại học Thủy Lợi

**Học phần:** Hệ thống Thông tin

**Nhóm:** Nhóm 5

---

# 14. License

Dự án được phát triển với mục đích **học tập và phục vụ đồ án môn học** tại Trường Đại học Thủy Lợi.

---

> **Hệ thống Quản lý Đồ án Tốt nghiệp**
> Được xây dựng bằng **Laravel + MySQL + Blade + Bootstrap 5**.
