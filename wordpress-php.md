# Các kinh nghiệm triển khai dự án với WordPress và PHP

## Đặt tên function

### Sử dụng classs hoặc prefix function thuần khi nào?

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

### Đặt tên function thuần cần có prefix của theme/plugin

```php
function codetot_woocommerce_get_product_query($args) {}
function ct_lms_get_course_query($args) {}
function azpet_get_hot_deal_query($args) {}
```

### Đặt tên function cần có các keyword để nhận biết dữ liệu là loại gì

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

### Có thể truyền optional parameter sau cùng cho mỗi function trực tiếp thay vì định nghĩa bên trong

```php
function codetot_get_product_query($query, $posts_per_page = 9) {
  // Sẽ không cần
  // $_posts_per_page = !empty($post_per_page) ? $posts_per_page : 9;
}
```

### Gộp 2 array $args sử dụng `wp_parse_args()`


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

### Bóc tách $args ra để dễ dàng thêm bớt nếu cần

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
