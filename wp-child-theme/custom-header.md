# Custom Header

To replace with custom header:

```php
add_action('wp', 'child_theme_custom_theme_header');
function child_theme_custom_theme_header() {
		$header = codetot_get_theme_mod('header_layout') ?? 'header-theme';

		if ($header === 'header-theme') {
			add_action('codetot_header', function () {
				the_block('header-theme');
			}, 1);
		}
	}
```

Then create `blocks/header-theme.php` in your child theme.
