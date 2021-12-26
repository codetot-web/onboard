# WordPress Query Tips
  
## Giảm query không cần thiết
  
```php
$post_args = [
  'no_found_rows' => true, // Chỉ dùng khi có pagination (case ở trên)
  'update_post_meta_cache' => false, // dùng khi không cần search thẻ post meta
  'update_post_term_cache' => false, // dùng khi không cần search trong taxonomy
  'fields' => 'ids'// dùng khi bạn chỉ muốn lấy list id các bài viết
];
```

## Tối ưu query không có pagination

Nếu block của bạn chỉ hiện 1 số bài nhất định mà không cần pagination, sử dụng `no_found_rows` sẽ tiết kiệm được query.
Nó giúp không cần tính `SQL_CALC_FOUND_ROWS` khi run SQL giúp tìm ra số tổng trang `paged`.

```php
<?php

$post_args = [
  'no_found_rows' => true,
];

$post_query = new WP_Query($post_args);
```
  
## Không sử dụng tìm bài không giới hạn
  
```php
$post_args = [
  'posts_per_page' => -1 // Nên dùng số giới hạn kết hợp pagination, còn -1 có thể làm site crash nếu quá nhiều post
];
```
  
## Hạn chế dùng `post__not_in`
  
Thực tế bạn có thể tìm cách lấy ra và dùng PHP để loại bằng `in_array()` thì sẽ tốt hơn là query trực tiếp vào `WP_Query`
  
```php
<?php
$exclude_posts = get_field('exclude_posts', 'options');  

$post_query = new WP_Query( array(
  'post_type' => 'post',
  'posts_per_page' => 30 + count( $exclude_posts )
) );

if ( $post_query->have_posts() ) :
    while ( $post_query->have_posts() ) :
        $post_query->the_post();
        if ( in_array( get_the_ID(), $exclude_posts ) ) {
            continue;
        }

        the_block('post-card');

    endwhile;
endif;
```
  
## Phân biệt taxonomy và post meta
  
- Taxonomy dùng để phân loại nhóm bài viết theo các yếu tố
- Post meta dùng để xác định các thông tin riêng của từng post.
  
Hạn chế tối đa việc tìm kiếm bài viết thông qua post meta. Nếu cần phải làm việc, chắc chắn nó không phải query chính và nó đã được cache.
  
## Query nhiều lớp
  
Thay vì query nhiều taxonomy, tìm cách để query mức tối thiểu và dùng PHP để lọc dữ liệu bạn cần.
  
## Không nên sử dụng `in_array`
  
Không nên sử dụng `in_array()` do hạn chế về khả năng mở rộng. Thay vào đó, tìm cách tạo ra 1 array và check `isset()` của giá trị trong array đó.
  
```php
<?php
$array = array(
  'foo' => true,
  'bar' => true,
);
if ( isset( $array['bar'] ) ) {
  // value is present in the array
}; 
```
