# Các helper function của công ty phát triển

## Các function lấy block (1 section/component/block), lấy `block_part`

Dùng tương tự `get_template_part()` về mặt sử dụng, nhưng cách truyền biến vào khác nhau 

```php
function the_block($block_name, $args = array()) {
  // Gọi từ các folder theo thứ tự lần lượt
  // Child theme /blocks/
  // Parent theme /blocks/
  // CT-Blocks plugin /blocks/
  
  // $block_name không cần .php
  
  // Luôn luôn echo
}

function get_block($block_name, $args) {
  // Tương tự the_block(), nhưng không echo mà trả về variable.
}

// Tương tự the_block(), nhưng lấy ở folder /block-parts/ hoặc custom child theme thông qua đọc part ở blocks.json
// Nhưng không truyền $args vào mà chỉ ouput ra
function the_block_part() {}
function get_block_part() {}
```

## Lấy file SVG

Cách cho file SVG vào:
Cho vào folder src/svg/, sau đó chạy webpack `npm run watch` hoặc `npm run build`, sẽ được copy chuyển vào `assets/svg/`

```php
function codetot_svg($name, $echo) {
  // Lấy file ảnh từ folder /assets/svg/[name].svg
  // Cho phép lấy theo thứ tự
  // 1. child theme
  // 2. parent theme ct-bones
  
  // $echo = true/false, cho phép hiện ra luôn hay trả về variable.
}
```

