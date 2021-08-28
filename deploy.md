# Deploy (Đưa website/source code lên live/demo/staging)

**Định nghĩa**
- Local: bản trên máy tính của mình
- Demo: bản để khách hàng review trước khi web ra mắt
- Staging: bản thử nghiệm, thường làm 1 tính năng trước khi phát hành trên live site
- Live: bản chính thức của khách hàng

## Hướng dẫn deploy theo quy trình sử dụng Git Submodule

**Git Submodule** cho phép nhúng nhiều git nhỏ như theme, plugin riêng vào chung 1 Git lớn (WordPress).

### Cài đặt lần đầu

1. Drop database cũ trong phpMyadmin và import database mới từ local/demo/staging lên.
2. Đổi `domain_url` và `site_url` trong table `wp_options` về đường dẫn site hiện tại
3. Đổi DNS nếu được cung cấp tài khoản, hoặc báo khách hay leader để đổi DNS
4. Cấp phát SSL trên hosting hoặc báo leader nếu không có tài khoản
5. Checkout code mới nhất

```
# 1. Cho ra kết quả là có git từ codetot-clients/***.git
git remote -v

# 2. Khởi tạo các child repository
git submodule init

# 3. Checkout code về từng repository
git submodule update

# 4. Reset tất cả git con về nhánh master
./scripts/update.sh

# [Lỗi nếu bước 4 không tiến hành được] Set phân quyền file .sh và chạy lại bước 4
chmod +x ./scripts/*.sh
```

### Deploy database SQL có dung lượng lớn

- Tải file SQL cần import lên thư mục dự án, vd /webapps/codetot hoặc /public_html/ trên hosting
- Export database hiện tại bằng phpMyAdmin ra 1 file local trên máy tính
- Drop tất cả table trong database trên phpMyAdmin (xóa hết tables nhưng không xóa database)
- Lấy thông tin database hiện tại của website, bao gồm username, database và password. (Thông thường username và database sẽ trùng nhau)
- Truy cập bằng SSH vào server, tìm tới thư mục chứa file .sql đã upload, chạy lệnh sau và nhập mật khẩu

```
$ mysql import -u DB_USER -p DB_NAME < FILE_NAME.sql
Enter password:
```

> Bạn cần nhập password bằng cách paste (nên dùng chuột phải để Paste) và ấn Enter. Sau khi chạy sẽ thấy một lúc sau con trỏ chuột lại bình thường, như vậy quá trình import đã thành công.

- Cấu hình table `wp_options`, tìm tới `site_url` và `home_url` đổi thành URL hiện tại (có https)
- Kiểm tra bằng cách truy cập `/wp-admin/` và đăng nhập. Vào Settings / Permalinks lưu lại 1 lần để đảm bảo link trên các trang con không bị chết.
- Kiểm tra cache và lưu ý xóa cache, hoặc tắt plugin cache và bật lại.
