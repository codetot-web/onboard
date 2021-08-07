# Các lưu ý khi thực hiện animation trên website

## Không sử dụng animation cho các thuộc tính không phù hợp

Ví dụ:

Sử dụng `transform` thay vì `left`, `right`

```css
@-webkit-keyframes icon-move-right {
  0% {
    transform: translateX(0);
  }

  100% {
    transform: translateX(15px);
  }
}

## Không transition `display: none`

Khi set thuộc tính `display: none;` hay chuyển `height: 0` lên `height: [number]px`, `transition: all` không có tác dụng vì trình duyệt sẽ render lại không chịu ảnh hưởng của animation.
Trong trường hợp muốn ẩn hiện đối tượng, nên sử dụng JS để tìm chiều cao scrollHeight của đối tượng bên trong, lấy chiều cao sau đó gán class.
Tham khảo block `accordion.js`.

```js
const activateTab = () => {
  map(tabEl => {
    if (tabEl !== currentTabEl) {
      removeClass(ACTIVE_CLASS, tabEl)
      removeAttribute('style', tabEl)
    } else {
      addClass(ACTIVE_CLASS, tabEl)
      
      const blockEl = select('.js-content', currentTabEl)
      const tabHight = blockEl ? getHeight(blockEl) : 0
  
      if (tabHeight > 0) {
        setAttribute('style', `min-height: ${tabHeight}px`, currentTabEl)
      }
  }, tabEls)
}
```
