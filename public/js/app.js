// app.js
const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
//Metódo para abrir modal 
document.getElementById('open-modal').addEventListener('click', function() {
    $('#modal').modal('show');
});