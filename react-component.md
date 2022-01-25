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
  
    return (
      <option value={articleType.value} checked={checked}>{articleType.name}</option>
    )
  })
```

### Xử lý 1 dữ liệu `state`

`state` là cách ta gọi 1 dữ liệu có thể được sửa chữa, thay đổi.

Ví dụ:

- Mở popup khi click vào nút bấm
- Khi 1 select được chọn option thay đổi, set giá trị sẽ sử dụng cho dữ liệu cần xử lý
- Khi click vào 1 item trong list để xóa hoặc thêm 1 item khác

Các dữ liệu trước đây dùng JS để gán class, ví dụ `addClass('d-none', item)` thì với React sẽ render và tự remove thông qua `state`

Lấy 1 ví dụ đơn giản với giá trị của 1 action ẩn/hiện element

```js
import { useState } from 'react'

const exampleComponent = props => {
  const [visible, setVisible] = useState(false) // set mặc định visible = false
  
  // Toggle
  const handleChangeVisible = () => {
    setVisible(!visible)
  }
  
  // console để thấy khi click giá trị sẽ tự thay đổi
  console.log(visible)
  
  return (
    <button onClick={handleChangeVisible}>{'Toggle visible'}</button>
  )
}
```

### Lấy dữ liệu dynamic từ 1 api endpoint

Trường hợp xảy ra khi ta muốn vào 1 API endpoint, ví dụ `/wp/v2/posts` để lấy ra danh sách và render nó với React.

**Các lưu ý**

- Biến `exampleApiConfig` nên được config thông qua PHP hay backend để có thể access theo url.
- Nếu dữ liệu là các loại hình dữ liệu nào (array, bool true/false, string) thì `useState()` cần có định dạng tương ứng như `useState([])`, `useState({})`, `useState('')`
- Luôn bọc điều kiện để đảm bảo dữ liệu tồn tại thì mới output ra
- `useEffect(() => {}, [])` khi `[]` không có gì thì tức là chạy chỉ 1 lần khi render.

```js
/* global exampleApiConfig */
import { useState, useEffect } from 'react'
require('whatwg-fetch')

const exampleComponent = props => {
  const [cities, setCities] = useState([])

  useEffect(() => {
    fetch(exampleApiConfig.restUrl)
      .then(res => res.json())
      .then(res => {
        if (res.cities) {
          setCities(res.cities)
        }
      })
  }, [])
  
  return (
    <select>
      {cities && cities.length ? cities.map(city => {
        return (
          <option value={city.value}>{city.name}</option>
        )
      } : '')
    </select>
  )
}
```

### Sử dụng `PropTypes`

Tương tự như `Typescript`, React có thư viện `PropTypes` giúp kiểm tra các dữ liệu truyền vào có đúng định dạng (vd number, string, array, object) không giúp giảm thiểu code lỗi. Điều này giúp hạn chế việc truyền sai kiểu dữ liệu, hoặc truyền vào nhưng chưa format dữ liệu theo đúng định dạng quy ước.

Tham khảo: https://reactjs.org/docs/typechecking-with-proptypes.html

Cài với npm

```
npm install --save prop-types
```

Dùng trong dự án ví dụ:

```js
import PropTypes from 'prop-types'

const MobileFiltersApp = props => {}

MobileFiltersApp.propTypes = {
	defaultSettings: PropTypes.object
}
```
