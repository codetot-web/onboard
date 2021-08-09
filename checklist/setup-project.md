# Setup project

Người chịu trách nhiệm: Leader có quyền truy cập Runcloud + GitHub phần settings dự án.

## Bước 1: Khởi tạo repository GitHub mới và đẩy code từ base lên

1. Khởi tạo git mới trong GitHub [codetot-clients](https://github.com/codetot-clients)
2. Clone git mới tạo vào trong folder trên máy.

```bash
git clone git@github.com:codetot-clients/gomsuxaydung.vn.git
cd gomsuxaydung.vn/
```

3. Vào folder, thêm 1 upstream mới chính là bản `wordpress` hoặc `wordpress-shop.git`

```bash
git remote add upstream git@github.com:codetot-web/wordpress-shop.git
git fetch upstream
```

4. Sau khi thấy `upstream/master` mới về, reset folder về nhánh này.

```bash
git reset --hard origin/master
```

5. Tiến hành đẩy các nhánh `master`, `production` lên.

```bash
git push origin HEAD:master
git push origin HEAD:production
```

## Bước 2: Tạo child theme

1. Clone child theme vào folder `wp-content/themes/`

```bash
cd wp-content/themes/
git clone git@github.com:codetot-web/ct-child-theme.git <tên folder theme>
```

2. Mở File Explorer hoặc vào Git Bash xóa folder `.git/`

```bash
cd <tên folder theme>
rm -rf .git/
```

3. Đổi tên child theme và text domain

Sửa các file sau:

```
style.css
inc/child-theme-init.php
```

Ví dụ đổi tên theme:

```css
/**
Theme Name: <tên dự án viết không dấu>
Theme URI: https://codetot.com <có thể bỏ>
Author: Code Tot JSC
Author URI: https://codetot.com
Tags: codetot-theme
Text Domain: <tên folder child theme>
Template: ct-bones
Version: 0.0.1 <đổi về 0.0.1>
 */
```

Ví dụ đổi codetot-child thành tên folder child theme.

```php
load_child_theme_textdomain('codetot-child')
```

4. Chuyển ra folder WordPress và up code mới lên

```bash
cd ../../../
git add wp-content/themes/
git commit -m "Add child theme"
git push origin HEAD:master
```

## Bước 3: Cấu hình Circle CI để build lên branch develop

Truy cập [Circle CI codetot-clients](https://app.circleci.com/projects/project-dashboard/github/codetot-clients/).

1. Vào cấu hình bật deploy qua file `.circleci/config.yml`
2. Vào Project Settings, nhập **Environment Variables**

```
THEME_NAME: <tên folder theme>
```

3. Chạy lại Circle CI cho branch develop hoặc master để kiểm tra
