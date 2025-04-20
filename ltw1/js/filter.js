document.addEventListener('DOMContentLoaded', function() {
    // Hàm lọc sản phẩm
    function filterProducts() {
        const filterValue = document.getElementById('filter_options').value;
        const products = Array.from(document.querySelectorAll('.product_item'));
        let filteredProducts = products.slice(); // Sao chép mảng để không thay đổi thứ tự ban đầu

        // Xử lý giá trị lọc
        if (filterValue === 'coffee' || filterValue === 'tea' || filterValue === 'frozen') {
            // Lọc theo loại nước
            filteredProducts = products.filter(product => 
                product.getAttribute('data-type') === filterValue
            );
        } else if (filterValue === 'asc') {
            // Sắp xếp giá tăng dần
            filteredProducts.sort((a, b) => 
                parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'))
            );
        } else if (filterValue === 'desc') {
            // Sắp xếp giá giảm dần
            filteredProducts.sort((a, b) => 
                parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'))
            );
        }

        // Hiển thị hoặc ẩn sản phẩm mà không thay đổi cấu trúc row
        products.forEach(product => {
            if (filteredProducts.includes(product)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });

        // Sắp xếp lại thứ tự hiển thị
        const productList = document.getElementById('product_list');
        filteredProducts.forEach(product => {
            productList.appendChild(product); // Di chuyển phần tử để sắp xếp
        });

        console.log('Lọc tự động:', { filterValue, filteredCount: filteredProducts.length });
    }

    // Gắn sự kiện change cho select
    const filterSelect = document.getElementById('filter_options');
    if (filterSelect) {
        filterSelect.addEventListener('change', filterProducts);
        // Gọi lần đầu để hiển thị mặc định
        filterProducts();
    } else {
        console.error('Không tìm thấy filter_options');
    }
});