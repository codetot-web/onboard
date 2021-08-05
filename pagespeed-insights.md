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
    
    // Init slider...
  }
  
  on('load', throttle(init, 300), window)
  on('scroll, throttle(init, 300, window)
}
```
