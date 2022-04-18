# Làm việc với database trong WordPress

**Điều kiện**

- Sử dụng LocalWP trên máy
- Đã cài đặt dự án thành công

## Đổi mật khẩu tài khoản trong MySQL

Trường hợp không đăng nhập được vào /wp-admin do không nhớ mật khẩu.

1. Chọn dự án / tìm tab Database / click vào "Open Adminer"
2. Tìm table `wp_users` hoặc `xxx_users`
3. Chọn tab "Select data"
4. Edit dòng chứa user cần đổi mật khẩu
5. Ở mục `user_pass`, chọn select `md5` và nhập mật khẩu mới, ví dụ `codetot@` vào
6. Ấn Save để lưu mật khẩu mới
