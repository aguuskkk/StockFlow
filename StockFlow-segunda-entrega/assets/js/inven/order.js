const orderBtn = document.getElementById('order-btn');
const contentList = document.getElementById('content-list');

orderBtn.addEventListener('click', () => {
    contentList.classList.toggle('active');
});