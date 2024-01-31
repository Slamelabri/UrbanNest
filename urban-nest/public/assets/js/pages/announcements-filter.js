const postalCodeInput = document.querySelector("input[name='filter[postalCode]']");
const selectCity = document.querySelector("select[name='filter[city]']");
if (postalCodeInput){
    postalCodeInput.addEventListener("change", async function (event) {
        if(postalCodeInput.value){
            selectCity.parentElement.classList.add("form-loading");
            //Appeller l'API
            const response = await fetch("https://apicarto.ign.fr/api/codes-postaux/communes/" + this.value);
            const cities = await response.json();

            //Supprimer les options existantes
            selectCity.innerHTML = "";
            //Ajouter option par defaut
            const defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "--Sélectionner une ville--";
            selectCity.appendChild(defaultOption);

            if(cities.length > 0){
                cities.forEach(city => {
                    const option = document.createElement("option");
                    option.value = city.nomCommune;
                    option.textContent = city.nomCommune;
                    selectCity.appendChild(option);
                });
            }
        }
        selectCity.parentElement.classList.remove("form-loading");
    });
}

//Typing Effect
let word = 0;
let wordEnd = false;
let i = 0;
let txt = ['Gestion locative', 'Vente immobilière'];
let speed = 50;
const containerText = document.querySelector("div.filter-title > div > h2");

function typeWriter(){
    if(i < txt[word].length && !wordEnd) {
        containerText.innerHTML += txt[word].charAt(i);
        i++;
    } else if (i == txt[word].length && !wordEnd) {
        wordEnd = true;
    } else if(wordEnd && i >= 0){
        containerText.innerHTML = containerText.innerHTML.substring(0, containerText.innerHTML.length - 1);
        i--;
    } else {
        if(word == (txt.length - 1)){
            word = 0;
        } else {
            word++;
        }
        i = 0;
        wordEnd = false;
    }
    setTimeout(typeWriter, speed);
}

typeWriter();

//Sending Form
const form = document.getElementById('formFilter');
form.querySelector('button').addEventListener('click', function(e){
    e.preventDefault();

    const type = document.getElementById('project_buying').checked ? 'sale' : 'location';
    const propertyType = document.getElementById('property_type').value;
    const postalCode = document.getElementById('postal_code').value;
    const city = document.getElementById('city').value;

    if(!postalCode){
        alert('Veuillez renseigner un code postal');
        return;
    }

    let url = `/announcements/${type}/${postalCode}/list?q`;

    if (city){
        url += `&city=${city}`;
    }

    if (propertyType){
        url += `&propertyType=${propertyType}`;
    }

   window.location.href = url;
});