# Postman API

Để thuận tiện cho việc triển khai backend, công ty cung cấp tài khoản dùng chung trên Postman - phần mềm giúp thiết kế và kiểm tra API. Tải app từ postman.com và đăng nhập để bắt đầu.

## Các khái niệm cơ bản

**Collection**

Là các thư mục chứa các API endpoint (hoặc/và các kết quả của nó).

Ví dụ:

Collection "**ID Nhà Phố Net - OAuth 2**" chứa các endpoint để tương tác với tài khoản.

**API Endpoint**

Là các đường dẫn truy cập vào theo cấu trúc và truyền các dữ liệu vào để thực thi và nhận kết quả.

Ví dụ triển khai gọi 1 dữ liệu bằng AJAX vào URL `/get_collection/{$collection_id}` như sau:

```js
fetch(`/get_collection/{$collection_id}`)
  .then(res => res.json())
  .then(data => {
    if (data.collection) {
      setCollection(data.collection)
    }
  })
  .catch(err => {
    if (err.errorMessage) {
      setError(err.errorMessage)
    }
  })
```

**Response**

Cho phép lưu lại các kết quả truy xuất vào **API Endpoint** ở trên để tham khảo, bao gồm thành công và không thành công.
