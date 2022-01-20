# phpcs - PHP Coding Standards

**Tại sao cần phpcs**

- Quy chuẩn hóa toàn bộ cách viết PHP hợp lệ
- Đảm bảo các tiêu chuẩn bảo mật

**Cách thức setup**

- Trên máy cần có `composer`. Xem cách cài đặt composer và đảm bảo trên máy có `composer`.
- Đọc file `phpcs.xml.dist` của 1 dự án, ví dụ [ct-bones](https://github.com/codetot-web/ct-bones/blob/production/phpcs.xml.dist) để nắm được cách rules nào sẽ áp dụng cơ bản
- Chạy `composer install` trên dự án nào có file `composer.json`
- Xem các command để chạy ở `scripts` của file `composer.json`, ví dụ:

```json
{
 "scripts": {
      "standards:check": "@php ./vendor/squizlabs/php_codesniffer/bin/phpcs",
      "standards:fix": "@php ./vendor/squizlabs/php_codesniffer/bin/phpcbf",
      "lint": "@php ./vendor/bin/parallel-lint --exclude .git --exclude vendor .",
      "analyze": "@php ./vendor/bin/phpstan analyze"
  }
}
```

Command phổ biến là `standards:check` để tự check trên máy, `standards:fix` để fix tự động 1 số lỗi (nhưng không hết), `lint` để thực thi test.

Có thể lên CircleCI để xem report cụ thể và fix theo từng file.

## Một số quy tắc cần tuân thủ

Sử dụng `escape` và `sanitize` - bao gồm nhiều function để format dữ liệu khi thu thập từ người dùng (vd từ đường dẫn), từ input (vd nhập text).

[Xem thêm](https://github.com/codetot-web/dev-guideline/blob/main/wordpress-php.md#sanitizationescaping-c%C3%A1c-gi%C3%A1-tr%E1%BB%8B-khi-c%E1%BA%A7n-thi%E1%BA%BFt-%C4%91%E1%BB%83-h%E1%BA%A1n-ch%E1%BA%BF-b%E1%BB%8B-t%E1%BA%A5n-c%C3%B4ng)

Các dự án có quy tắc set prefix cụ thể thì sẽ cần đảm bảo các function sử dụng bắt đầu bằng các prefix function.

[Xem thêm](https://github.com/codetot-web/dev-guideline/blob/main/wordpress-php.md#sanitizationescaping-c%C3%A1c-gi%C3%A1-tr%E1%BB%8B-khi-c%E1%BA%A7n-thi%E1%BA%BFt-%C4%91%E1%BB%83-h%E1%BA%A1n-ch%E1%BA%BF-b%E1%BB%8B-t%E1%BA%A5n-c%C3%B4ng)

Hạn chế việc output HTML trong biến của PHP để hạn chế code quét security level cao

[Xem thêm](https://github.com/codetot-web/dev-guideline/blob/main/wordpress-php.md#lo%E1%BA%A1i-b%E1%BB%8F-html-kh%E1%BB%8Fi-echo-trong-php)
