const btnAbrirModal = document.querySelector("#btn-abrir-modal");
const btnAbrirModalEmail = document.querySelector("#btn-abrir-modal-email");
const btnAbrirModalPicture = document.querySelector("#btn-abrir-modal-picture");
const btnCerrarModal = document.querySelector("#btn-cerrar-modal");
const btnCerrarModalEmail = document.querySelector("#btn-cerrar-modal-email");
const btnCerrarModalPicture = document.querySelector("#btn-cerrar-modal-picture");
const modal = document.querySelector("#modal");
const modalEmail = document.querySelector("#modal-email");
const modalPicture = document.querySelector("#modal-picture");

btnAbrirModal.addEventListener('click', ()=>{
    modal.showModal();
});

btnAbrirModalEmail.addEventListener('click', ()=>{
    modalEmail.showModal();
});

btnAbrirModalPicture.addEventListener('click', ()=>{
    modalPicture.showModal();
});

btnCerrarModal.addEventListener('click', ()=>{
    modal.close();
});

btnCerrarModalEmail.addEventListener('click', ()=>{
    modalEmail.close();
});

btnCerrarModalPicture.addEventListener('click', ()=>{
    modalPicture.close();
});