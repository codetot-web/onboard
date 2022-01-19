# WP REST API

Mặc dù WordPress cung cấp sẵn endpoint `wp/v2/posts` để lấy dữ liệu, thực tế ta vẫn có nhu cầu lấy dữ liệu theo cách riêng bằng cách sử dụng custom rest route.

```php
<?php
// inc/api.php

add_action('rest_api_init', 'theme_prefix_rest_api_init');
function theme_prefix_rest_api_init() {
  $namespace = 'example-namespace/';
  $version     = 'v1';

    register_rest_route("$namespace/$version", 'get_example_post_type', array(
        'methods'   => WP_REST_Server::READABLE,
        'callback'  => 'at_rest_testing_endpoint'
    ));
}

/**
 * @param WP_REST_Request $request
 * @response WP_REST_Response
 */
function theme_prefix_get_example_post_type_callback($request) {
  
}
```

**Chú ý**

- Để tiện cho việc đặt tên, nên quy tắc `endpoint_function_name` là gì thì function load sẽ là `endpoint_function_name_callback`.
- Function callback luôn luôn return `WP_REST_Response` bất kể dữ liệu có hay không.

```php
<?php
function example_rest_callback() {
  return new WP_REST_Response([
    'items' => []
  ], 200);
}
```

- Function return nên tuân thủ HTTP Status code

```
- Không đầy đủ dữ liệu đầu vào, ví dụ cần `$type = $request->get_param('type')` mà không có thì cần trả về mã là 400 (Bad Request).
- Có dữ liệu thì trả về mã là 200
- Tạo dữ liệu từ request (vd tạo post), trả về mã là 201
- Nếu báo lỗi, ví dụ query bài viết nhưng bài viết không có thì trả về mã là 404
```

- Nếu báo lỗi thì trả về kết quả là cặp array gồm `errorCode` và `errorMessage`

```php
return new WP_REST_Response([
  'errorCode' => 404,
  'errorMessage' => esc_html__('There is no posts to display', 'text-domain')
], 404);
``
