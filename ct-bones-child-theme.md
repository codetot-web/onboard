# Hướng dẫn override trên child theme

Child Theme Git: https://github.com/codetot-web/ct-child-theme

## Tạo Header riêng cho theme

Tạo 1 option trong CT Theme và cho phép người dùng chọn thì load file `/blocks/header-custom.php` trong child theme.

```php

class Codetot_Child {
  public function __construct()
  {
    add_action('wp_loaded', array($this, 'load_custom_header'));
    add_filter('codetot_settings_header_options', array($this, 'custom_header_options'));
  }

  public function load_custom_header() {
    $header_layout = !empty(get_global_option('codetot_header_layout')) ? str_replace('header-', '', get_global_option('codetot_header_layout')) : '1';

    if ($header_layout === 'theme') {
      add_action('codetot_header', function () {
        the_block_part('header-custom');
      }, 1);
    }
  }

  public function custom_header_options($options) {
    $options['theme'] = 'https://placeimg.com/300/300/tech';

    return $options;
  }
```
