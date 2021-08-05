# Sử dụng Webpack trong dự án

## Nodejs command phổ thông

```
npm run watch // Chạy localhost:3000 mở tab mới trình duyệt
npm run build // Chạy bản build .min.css, .min.js phục vụ deploy (thường do GitHub tự build trên branch develop)
npm run fix // Chạy fix các lỗi code standard CSS, JS, PHP (sai tab indent, xuống dòng...)
npm run test // Kiểm tra các lỗi code standard nhưng không fix, trả về báo lỗi nếu thấy
```

## Cấu hình local domain

Để `npm run watch` hoạt động đúng domain, ban cần vào cấu hình file `config/webpack.settings.js``

```js
proxy: {
  target: 'http://codetot-shop.test', // Thay chỗ này
  proxyReq: [
    proxyReq => {
      proxyReq.setHeader('X-Codetot-Header', 'development')
    }
  ]
},
```

## Cho phép copy file/folder trong `src/`

Một số file cần copy thì .svg, .png thì cần bổ sung thao tác copy cho Webpack, tiến hành như sau:

File: `webpack.common.js`

Có file nào thì copy {} của cái đó, nếu không sẽ báo lỗi.

Ví dụ như copy 1 thư viện jQuery, thì copy file chưa .min.js vd jquery.validate.js vào folder src/js/vendors/jquery.validate.js

Sau đó copy đoạn copy chỉ file vendor js vào như thế này:

```js
{
  from: '**/vendors/*.js',
  to: '[path][name].min.[ext]',
  context: path.resolve(process.cwd(), settings.paths.src.base)
}
```

Source tham khảo đầy đủ:

```js
const CopyWebpackPlugin = require('copy-webpack-plugin') // Cái này thêm vào phía trên cùng

...
new CopyWebpackPlugin({
  patterns: [
    {
      from: '**/vendors/*.js',
      to: '[path][name].min.[ext]',
      context: path.resolve(process.cwd(), settings.paths.src.base)
    },
    {
      from: '**/*.{jpg,jpeg,png,gif}',
      to: '[path][name].[ext]',
      context: path.resolve(process.cwd(), settings.paths.src.base)
    },
    {
      from: '**/*.svg',
      to: '[path][name].[ext]',
      context: path.resolve(process.cwd(), settings.paths.src.base)
    }
  ]
}),
```
