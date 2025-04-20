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

// js/pagination.js
document.addEventListener('DOMContentLoaded', function () {
    const products = document.querySelectorAll('.product_item'); // Lấy tất cả sản phẩm
    const productsPerPage = 9; // Số sản phẩm trên mỗi trang
    const totalPages = Math.ceil(products.length / productsPerPage); // Tính tổng số trang
    const paginationList = document.getElementById('pagination_list'); // Container phân trang
    let currentPage = 1; // Trang hiện tại

    // Hàm hiển thị sản phẩm theo trang
    function showProducts(page) {
        products.forEach((product, index) => {
            product.style.display = 'none'; // Ẩn tất cả sản phẩm
            if (index >= (page - 1) * productsPerPage && index < page * productsPerPage) {
                product.style.display = 'block'; // Hiện sản phẩm thuộc trang
            }
        });
    }

    // Hàm tạo các liên kết phân trang
    function renderPagination() {
        paginationList.innerHTML = ''; // Xóa nội dung cũ

        // Nút Previous
        const prevItem = document.createElement('li');
        prevItem.classList.add('pagination-item');
        prevItem.innerHTML = `<a href="#" class="pagination-item__link"><i class='bx bx-chevron-left'></i></a>`;
        if (currentPage === 1) prevItem.classList.add('disabled');
        prevItem.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });
        paginationList.appendChild(prevItem);

        // Các số trang
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('li');
            pageItem.classList.add('pagination-item');
            if (i === currentPage) pageItem.classList.add('pagination-item--active');
            pageItem.innerHTML = `<a href="#" class="pagination-item__link">${i}</a>`;
            pageItem.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                updatePagination();
            });
            paginationList.appendChild(pageItem);
        }

        // Nút Next
        const nextItem = document.createElement('li');
        nextItem.classList.add('pagination-item');
        nextItem.innerHTML = `<a href="#" class="pagination-item__link"><i class='bx bx-chevron-right'></i></a>`;
        if (currentPage === totalPages) nextItem.classList.add('disabled');
        nextItem.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });
        paginationList.appendChild(nextItem);
    }

    // Hàm cập nhật trạng thái phân trang và sản phẩm
    function updatePagination() {
        showProducts(currentPage);
        renderPagination();
    }

    // Khởi tạo
    updatePagination();
});