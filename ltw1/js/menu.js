// Xử lý nút Thêm vào giỏ hàng
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        // Tìm phần tử cha chứa thông tin sản phẩm
        const productElement = this.closest('.product_item');

        // Kiểm tra xem sản phẩm có tồn tại không
        if (!productElement) {
            console.error('Không tìm thấy sản phẩm chứa nút này!');
            return;
        }

        // Lấy thông tin sản phẩm
        const productName = productElement.querySelector('.product_name')?.textContent || 'Sản phẩm không xác định';
        const productPrice = productElement.querySelector('.product_price')?.textContent.replace(' VND', '').replace(',', '') || '0';
        const productImage = productElement.querySelector('.product_image')?.src || '';

        // Hiển thị thông tin sản phẩm trong Console (debug)
        console.log(`Thêm vào giỏ hàng: ${productName} - ${productPrice} VND`);

        // Lưu vào Local Storage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingProduct = cart.find(item => item.name === productName);

        if (existingProduct) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            existingProduct.quantity += 1;
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            cart.push({ 
                name: productName, 
                price: parseFloat(productPrice), 
                quantity: 1, 
                image: productImage 
            });
        }

        // Lưu lại giỏ hàng vào Local Storage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Thông báo thành công (tuỳ chọn)
        alert(`Đã thêm "${productName}" vào giỏ hàng!`);
    });
});
// Xử lý nút Thêm vào giỏ hàng
document.querySelectorAll('.go-login').forEach(button => {
    button.addEventListener('click', function () {
         // Tìm phần tử cha chứa thông tin sản phẩm
         const productElement = this.closest('.product_item');

         // Kiểm tra xem sản phẩm có tồn tại không
         if (!productElement) {
             console.error('Không tìm thấy sản phẩm chứa nút này!');
             return;
         }
        alert(`Bạn cần đăng nhập trước.`);
    });
});