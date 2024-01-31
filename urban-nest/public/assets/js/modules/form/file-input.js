const fileInputs = document.querySelectorAll('.form-file');
if(fileInputs.length > 0){
    fileInputs.forEach((inputContainer)=>{
        inputContainer.querySelector('input').addEventListener('change', function(e){
            const files = this.files;
            let name = files[0].name;

            if(this.multiple){
                const containerFiles = inputContainer.querySelector('.files');
                containerFiles.innerHTML = '';
                for(let i = 0; i < files.length; i++){
                    const filename = document.createElement('span');
                    filename.textContent = files[i].name;
                    containerFiles.append(filename);
                }
            } else {
                inputContainer.querySelector('.filename').textContent = files[0].name;
                inputContainer.querySelector('span.btn-primary').textContent = 'Remplacer le fichier';
            }
        });
    });
}