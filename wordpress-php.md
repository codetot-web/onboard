# Các kinh nghiệm triển khai dự án với WordPress và PHP

## Sử dụng classs hoặc prefix function thuần khi nào?

```php
// Dùng trong trường hợp muốn tương tác với hook/action, nhưng không thêm mới markup, ví dụ không thêm mới block nào đó
// Lý do là để có thể mở rộng và xóa khi cần
class Codetot_Layout {
  public function init() {
    remove_action('codetot_footer', 'codetot_layout_slideout_menu', 10);
  }
}

// Function thêm mới cần nên viết ra ngoài và độc lập, không phụ thuộc vào class
function codetot_layout_render_slideout_menu {
  the_block('slideout-menu');
}
```

## Đặt tên function thuần cần có prefix của theme/plugin

```php
function codetot_woocommerce_get_product_query($args) {}
function ct_lms_get_course_query($args) {}
function azpet_get_hot_deal_query($args) {}
```

## Đặt tên function cần có các keyword để nhận biết dữ liệu là loại gì

```php
// _render tức là hiển thị ra
function codetot_layout_render_slideout_menu {
  the_block('slideout-menu');
}

// _get tức là lấy ra (không echo)
// _query tức là sẽ trả về WP_Query
function codetot_get_product_query($product_args) {}

// _get tức là lấy ra (không echo)
// _query tức là sẽ trả về array
function codetot_get_product_args() {}
```

## Có thể truyền optional parameter sau cùng cho mỗi function trực tiếp thay vì định nghĩa bên trong

```php
function codetot_get_product_query($query, $posts_per_page = 9) {
  // Sẽ không cần
  // $_posts_per_page = !empty($post_per_page) ? $posts_per_page : 9;
}
```

## Gộp 2 array $args sử dụng `wp_parse_args()`


```php
function codetot_get_post_query($custom_post_args) {
  $default_args = array(
    'post_type' => 'post',
    'posts_per_page' => get_option('posts_per_page')
  );

  // Tương tự array_merge() trong PHP, nhưng được WordPress xử lý nữa rồi
  $post_args = wp_parse_args($custom_post_args, $default_args);

  return new WP_Query($post_args);
}
```

## Điều kiện bọc ngoài bằng 1 element hay wrapper div cho dễ đọc

- Case thường gặp: có thể có link hoặc không có link.
- Cách xử lý: Tạo 1 biến riêng và set điều kiện cho output ra

```php
<?php
ob_start();
the_block('image', array(
  'image' => $image,
  'class' => 'image--cover image--square logo-grid__image',
  'size' => 'medium'
));
$content = ob_get_clean();

if (!empty($link)) {
  printf('<a class="logo-grid__link" href="%1$s">%3$s</a>,
    esc_attr($link),
    $content
  );
} else {
 // Không nên echo $content thẳng ra, mà tạo 1 div tương đương tiến hành css cho cả __link lẫn __block
  printf('<div class="logo-grid__block">%s</div>, $content);
}
```

## Bóc tách $args ra để dễ dàng thêm bớt nếu cần

```php
function codetot_get_post_args($categories = []) {
  $post_args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
  );
  $tax_query = array();

  if (!empty($categories)) {
    $tax_query[] = array(
      'taxonomy' => 'course_category',
      'field' => 'term_id',
      'terms' => $categories
    );
  }

  if (count($tax_query) > 1) {
    $tax_query['relation'] = 'AND';
  }

  if (!empty($tax_query)) {
    $post_args['tax_query'] = $tax_query;
  }

  return $post_args;
}
```

## Sanitization/Escaping các giá trị khi cần thiết để hạn chế bị tấn công

Tài liệu tham khảo: https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/

Các giá trị thu thập được từ $_GET, $_POST hay từ data người dùng nhập đều cần xử lý qua các function để hạn chế tấn công.

```
sanitize_email()
sanitize_file_name()
sanitize_html_class()
sanitize_key()
sanitize_meta()
sanitize_mime_type()
sanitize_option()
sanitize_sql_orderby()
sanitize_text_field()
sanitize_title()
sanitize_title_for_query()
sanitize_title_with_dashes()
sanitize_user()
esc_url_raw()
wp_filter_post_kses()
wp_filter_nohtml_kses()
```

Các function `esc_`

```
esc_html()// <h2><?php echo esc_html( $title ); ?></h2>
esc_url() // <img src="<?php echo esc_url( $great_user_picture_url ); ?>" />
esc_js()
esc_attr() // <ul class="<?php echo esc_attr( $stored_class ); ?>"> </ul>
esc_textarea() // <textarea><?php echo esc_textarea( $text ); ?></textarea>
```

Ngoài ra còn có escape cho các phần language cần dịch:

```
esc_html__()
esc_html_e()
esc_html_x()
esc_attr__()
esc_attr_e()
esc_attr_x()
``

Và escape cho post_content:

```
echo wp_kses_post( $post_content );
```
