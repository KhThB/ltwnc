// Lấy các phần tử cần dùng
const paymentSelect = document.getElementById('payment');
const creditCardForm = document.getElementById('credit-card-form');
const bankTransferForm = document.getElementById('bank-transfer-form');

// Lắng nghe sự kiện thay đổi trên dropdown
paymentSelect.addEventListener('change', function () {
  if (this.value === 'credit_card') {
    creditCardForm.style.display = 'block'; // Hiện form nhập thẻ tín dụng
    bankTransferForm.style.display = 'none'; // Ẩn thông tin ngân hàng
  } else if (this.value === 'bank_transfer') {
    bankTransferForm.style.display = 'block'; // Hiện thông tin ngân hàng
    creditCardForm.style.display = 'none'; // Ẩn form nhập thẻ tín dụng
  } else {
    // Ẩn cả hai form nếu chọn phương thức khác
    creditCardForm.style.display = 'none';
    bankTransferForm.style.display = 'none';
  }
});
paymentSelect.addEventListener('change', function () {
    console.log('Giá trị được chọn:', this.value);
    if (this.value === 'credit_card') {
      console.log('Hiển thị form thẻ tín dụng');
      creditCardForm.style.display = 'block';
      bankTransferForm.style.display = 'none';
    } else if (this.value === 'bank_transfer') {
      console.log('Hiển thị form chuyển khoản ngân hàng');
      bankTransferForm.style.display = 'block';
      creditCardForm.style.display = 'none';
    } else {
      console.log('Ẩn cả hai form');
      creditCardForm.style.display = 'none';
      bankTransferForm.style.display = 'none';
    }
  });
  