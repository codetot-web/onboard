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

## Sử dụng dữ liệu và render dữ liệu

### Array

```js
import { articleTypes } from 'lib/data/properties'

const optionComponents = props => {
  return (
    <div>
      <label for={props.name}>{props.label}</label>
      <select name={props.name}>
        <option value=''>{props.placeholder}</option>
        {articleTypes.map(articleType => (
          <option value={articleType.value}>{articleType.name}</option>
        ))
      </select>
    </div>
  )
}
```

Phân biệt 2 kiểu render 1 list array dữ liệu

```js
 // Return luôn dùng () => () và sử dụng luôn
 {articleTypes.map(articleType => (
    <option value={articleType.value}>{articleType.name}</option>
  ))

  // Có thể kèm 1 số function nào đó rồi mới return () => {}
  {articleTypes.map(articleType => {
    const checked = articleType.value === currentArticleType
  
    return <option value={articleType.value} checked={checked}>{articleType.name}</option>
  })
```
