document.addEventListener('DOMContentLoaded', () => {
    const orderBtns = document.querySelectorAll('#order_btn');
    orderBtns.forEach(orderBtn => {
        orderBtn.addEventListener('click', toggleModal);
    });
});

const toggleModal = () => {
    const modal = document.getElementById('order_modal');
    const modalBackdrop = document.querySelector('.modalBackdrop');


    modal.classList.toggle('d-none');
    modalBackdrop.classList.toggle('d-none');

    if (! modal.classList.contains('d-none') && ! modalBackdrop.classList.contains('d-none')) {
        modalBackdrop.addEventListener('click', (e) => handleClickOutside(e, modalBackdrop));
    } else {
        modalBackdrop.removeEventListener('click', (e) => handleClickOutside(e, modalBackdrop));
    }
}

const handleClickOutside = (e, modalBackdrop) => {
    if (e.target === modalBackdrop) {
        toggleModal();
    }
}

function printOrder(id) {
    var data = document.getElementById(id).innerHTML;
    var myWindow = window.open('', 'Bocaux des champs', 'height=400,width=600');
    myWindow.document.write('<html><head><title>Bocaux des champs</title>');
    myWindow.document.write('</head><body >');
    myWindow.document.write(data);
    myWindow.document.write('</body></html>');
    myWindow.document.close(); // necessary for IE >= 10

    myWindow.onload = function () { // necessary if the div contain images

        myWindow.focus(); // necessary for IE >= 10
        myWindow.print();
        myWindow.close();
    };
}