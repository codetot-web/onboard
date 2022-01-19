# React Component

## Tạo component mới trên base cơ bản

Cách thức tạo 1 React Component được thực hiện trên nền tương tự với `data-block`, `data-component` attribute như sau:

```js
// src/js/components/example-app.js
import React from 'react'
import ReactDOM from 'react-dom'

const ExampleApp = () => {
  <div className={'example-app-class'}></div>
}

export default el => {
  const appEl = select('#example-app-id', el)
  
  if (appEl) {
    ReactDOM.render(<ExampleApp />, appEl)
  }
}
```

```php
<?php
/**
 * Example app component
 *
 * @package theme
 * @author codetot
 * @since 0.0.1
 */
?>

<div class="example-app" data-component="example-app">
  <div id="example-app-id"></div>
</div>
```
