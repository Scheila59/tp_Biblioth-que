const preview = document.querySelector('#image-preview'); // sélectionner l'image
const input = document.querySelector('#image'); // sélectionner l'input

input.addEventListener('change', ()=> previewImage())

const previewImage = () => { // fonction pour afficher l'image
    const file = input.files[0]; // récupérer le fichier
    if (file) { // si le fichier existe
        const fileReader = new FileReader(); // créer un lecteur de fichier
        fileReader.onload = (e) => { // lire le fichier
            preview.setAttribute("src", e.target.result); // afficher l'image
        };
        fileReader.readAsDataURL(file);
    }   
}
