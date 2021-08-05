# Các kỹ thuật kiểm tra và khắc phục lỗi Google PageSpeed Insight

Link test: https://developers.google.com/speed/pagespeed/insights/

## Tối ưu trong source code

### Khu vực hiển thị first screen

Màn hình đầu tiên của người dùng luôn cần hạn chế tối đa lazyload. Các đối tượng hiển thị trong màn hình đầu tiên (khi chưa scroll hay tương tác) cần đảm bảo hiện ra.

**Với element là ảnh**
- Không có class `.lazyload`
- Không có thuộc tính `loading="lazy"`

Cách sử dụng phổ biến dễ nhất là:

```php
the_block('image', array(
  'lazyload' => false
));
```

### Load font chữ bằng inline CSS và ngay trong `<head>`

Các font chữ cần load bằng CSS inline. Thao tác thực hiện:

```php
// Get file content, ví dụ: assets/fonts.css
$file_path = CODETOT_CHILD_DIR . '/assets/fonts.css';
$file_content = file_exists($file_path) ? file_get_content($file_path) : '';

if ( !empty($file_content) ) :
  wp_register_style('child-font', false);
  wp_enqueue_style('child-font', false);
  wp_add_inline_style('child-font', $css_file_content);
endif;
```

### Các block hay element nằm ngoài đều cần lazyload

**Lazyload block `default-section`**

```php
the_block('default-section', array(
  'lazyload' => true
));
```

**Lazyload image**

```php
the_block('image', array(
  'lazyload' => true // Có thể không truyền thì vẫn nhận default = true rồi
));
```

Nếu có các custom block pass vao block default-section và load JS riêng của nó, vẫn triển khai lazyload dễ dàng thông qua JS

```php
the_block('default-section', array(
  'lazyload' => true,
  'attributes' => 'data-child-block="project-slider"'
));
```

```js
import { select, loadNoscriptContent } from 'lib/dom'
import { throttle } from 'lib/utils'
import Carousel from 'lib/carousel'

export default el => {
  const contentEl = select('.js-content', el)
  let slider = null
  let sliderEl = null
  let sliderOptions = null

  const init = () => {
     if (inViewPort(el) && hasClass('is-not-loaded', contentEl) {
       loadNoscriptContent(contentEl)
     }

    // Chuyển tất cả select + selectAll + các event + các phương thức cần cho vào đây
    if (!slider) {
        sliderEl = select('.js-slider', el)
        sliderOption = sliderEl ? getData('slider-options', sliderEl) : null
        sliderOptions = sliderOptions ? JSON.parse(sliderOptions) : {}
        
        slider = new Carousel(sliderEl, sliderOptions)
     }
  }
  
  on('load', throttle(init, 300), window)
  on('scroll', throttle(init, 300, window)
}
```

## Xử lý file ảnh

### Nén ảnh trong thư mục /themes/ child theme

Các ảnh dùng làm decor, ảnh nền trang trí trong theme, child theme, plugin đều cần được tối ưu trước khi upload lên.

https://tinyjpg.com
https://tinypng.com

Các ảnh khi cho lên cần resize sát khung hiển thị lớn nhất có thể, ví dụ 30x30px thì resize lại cho khớp, tránh upload ảnh 300x300px gây tốn tài nguyên.

## Nén ảnh trên website

Sử dụng plugin tùy theo từng khách hàng, có thể xin công ty API key bản premium để nén ảnh tốt hơn.

Chế độ nén đề xuất: Lossless (ít mất chất lượng)

## Kích thước ảnh

Nếu xác định sai kích thước ảnh sẽ rất dễ bị tính điểm trừ.

```php
the_block('image', array(
  'size' => 'thumbnail'
));
```

Các size này chỉ là ước tính size gốc, thực tế WordPress sử dụng `srcset` để xác định kích thước màn hình/file ảnh và load file tỷ lệ tương ứng. Tuy vậy, để đáp ứng ảnh mobile hiển thị, nên set size mặc đinh về `thumbnail` hoặc `medium`.

```
<img width="1024" height="683" 
src="https://dieuho.codetot.work/wp-content/uploads/2021/08/post-1-1-1024x683.jpg" 
class="wp-post-image image__img" 
alt="" 
srcset="https://dieuho.codetot.work/wp-content/uploads/2021/08/post-1-1-1024x683.jpg 1024w, https://dieuho.codetot.work/wp-content/uploads/2021/08/post-1-1-300x200.jpg 300w, https://dieuho.codetot.work/wp-content/uploads/2021/08/post-1-1-768x512.jpg 768w, https://dieuho.codetot.work/wp-content/uploads/2021/08/post-1-1-1536x1024.jpg 1536w, https://dieuho.codetot.work/wp-content/uploads/2021/08/post-1-1-2048x1366.jpg 2048w" 
sizes="(max-width: 1024px) 100vw, 1024px"
>
```
