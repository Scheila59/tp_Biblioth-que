const preview = document.querySelector('#image-preview');
const input = document.querySelector('#image');

input.addEventListener('change', ()=> previewImage())

const previewImage = () => {
    const file = input.files[0];
    if (file) {
        const fileReader = new FileReader();
        fileReader.onload = (e) => {
            preview.setAttribute("src", e.target.result);
        };
        fileReader.readAsDataURL(file);
    }   
}