const modalButtons = document.querySelectorAll('.modal > button');

const openModal = (e) => {
    const button = e.target;
    const target = button.getAttribute('data-modal-target');
    const popup = document.getElementById(target);
    const closeButtons = document.querySelectorAll('button[data-modal-hide]');
    popup.classList.remove('hidden');
    closeButtons.forEach((closeButton) => {
        closeButton.addEventListener('click', () => popup.classList.add('hidden'));
    });
}

modalButtons.forEach((modalButton) => {
    modalButton.addEventListener('click', openModal);
});