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
