# Deploy (Đưa website/source code lên live/demo/staging

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
