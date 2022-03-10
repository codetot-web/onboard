# LocalWP

LocalWP là ứng dụng để phục vụ việc build server sử dụng mã nguồn WordPress.

## Cài đặt

Tải về tại https://localwp.com/, click để hiện form popup tải về (nhập email fake là được) để tải về. Nếu trên máy đã có rồi thì bỏ qua bước này.

## Thêm website mới

Do hệ thống website đều sử dụng GitHub để lưu nguyên website (trừ folder `wp-content/uploads`), nên cách thực hiện tiến hành như sau:

1. Tạo website mới trong LocalWP. Domain nên trùng với domain trong `wp-content/themes/<tên theme>/webpack.config.js`
2. Vào folder chứa code mới tạo, ví dụ sẽ là `app/public`
3. Sao chép file `wp-config.php` ra folder `app/` (folder cha)
4. Xóa tất cả file trong folder `app/public/`
5. Chạy lệnh `git init`
6. Chạy lệnh `git remote add origin <git repo>`, ví dụ `git remote add origin git@github.com:codetot-clients/nhaphonet.git`
7. Chạy lệnh lấy code mới nhất `git fetch origin`
8. Chạy lệnh reset về nhánh `develop`: `git checkout origin/develop`, và tạo branch `develop` trên máy `git checkout -B develop`
9. Sao chép file `wp-config.php` ở bước 3 vào lại folder `app/public`. Thêm `WP_DEBUG`, `WP_DEBUG_LOG` giá trị `true`.
10. Lấy file SQL mới nhất của dự án (liên hệ leader hoặc tự lấy nếu được cấp quyền). File có thể là .sql.zip hay .sql.gz thì giải nén ra file .sql
11. Mở HeidiSQL app ra, nhập thông tin database trong tab Database trên LocalWP. Table chính là `local`
12. Drop toàn bộ dữ liệu nếu có, sau đó chọn `File | Run SQL...` và chọn file
13. Sau khi import xong, sửa table `wp_options`, tìm `home_url`, `site_url`, sửa lại thành url local, ví dụ `http://nhaphonet.test`
14. Kiểm tra đường dẫn truy cập xem đã hoạt động chưa
15. Truy cập `wp-admin/` bằng user/pass (hỏi leader), sau đó vào plugin CT Optimization, tick `Enable CDN domain`, nhập domain live, ví dụ `nhaphonet.vn` để media load không bị lỗi 404 nữa.
