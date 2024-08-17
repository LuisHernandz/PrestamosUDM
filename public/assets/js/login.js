const inputs = document.querySelectorAll('.input');

// function focusFunc(){
//     let parent = this.parentNode.parentNode;
//     parent.classList.add('focus')
// }

// function blurFunc(){
//     let parent = this.parentNode.parentNode;
//     if(this.value == ""){
//         parent.classList.remove('focus')
//     }
// }

// inputs.forEach(input => {
//     if (input.value !== "") {
//         let parent = input.parentNode.parentNode;
//         parent.classList.add('focus');
//     }

//     input.addEventListener('focus', focusFunc);
//     input.addEventListener('blur', blurFunc);
// });

function focusFunc() {
    let parent = this.parentNode.parentNode;
    if (this.value !== "" || this === document.activeElement) {
        parent.classList.add('focus');
    }
}

function blurFunc() {
    let parent = this.parentNode.parentNode;
    if (this.value === "") {
        parent.classList.remove('focus');
    }
}

inputs.forEach(input => {
    // Verificar si el campo de entrada ya tiene un valor al cargar la página
    if (input.value !== "") {
        let parent = input.parentNode.parentNode;
        parent.classList.add('focus');
    }
    
    input.addEventListener('focus', focusFunc);
    input.addEventListener('blur', blurFunc);
});
