# Code Coverage (Độ bao phủ unit test cho code)

**Tìm hiểu chung và giải thích**

Một function trong code luôn cần được kiểm thử tới từng trường hợp cụ thể tùy theo logic của nó.

Lấy ví dụ:

```js
function addClass(className, element) {
  element.classList.add(className);
}
```

Function này có gì cần kiểm tra?
- Liệu element được truyền vào có class ta gọi?
- Nếu element không có, function có lỗi không?
- Nếu className truyền rỗng, liệu function có hoạt động không?

Bởi vậy, trong trường hợp này, là cách ta xây dựng unit testing như thế nào để đảm bảo từng dòng code đều được thực hành kiểm tra logic đầy đủ.
Một cách rõ ràng hơn, thực ra, là ta phải đặt dữ liệu thực tế vào và thực hiện unit testing kiểm tra.

Kiểm tra có thể dùng 1 số thư viện, và nên được kiểm tra tự động bởi CircleCI hoặc thư viện độc lập.

Cách kiểm tra phổ biến là sử dụng với trình duyện Chrome, chẳng hạn

```js
beforeEach(() => {
	document.body.innerHTML = `<div class="one two three"></div>`
})

const getElementClass = el => el.className

test('test addClass', () => {
	const targetEl = document.body.querySelector('.one')
	addClass('fourth', targetEl)

	expect(getElementClass(targetEl)).toEqual('one two three fourth')
})
```

Xem thêm nhiều ví dụ hơn tại [dom.test.js trong ct-bones](https://github.com/codetot-web/ct-bones/blob/develop/src/js/lib/dom.test.js)

(còn tiếp)
