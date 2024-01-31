const postalCodeInput = document.querySelector("input#announce_localisation_postalCode");
const selectCity = document.querySelector("select#announce_localisation_city");
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


//Estimation du prix du biens
const formPriceArea = document.querySelector("input#form_price_area");
const inputArea = document.querySelector("input#announce_property_area");
if(formPriceArea){
    formPriceArea.addEventListener("change", function (event) {
        if(formPriceArea.value){
            formPriceArea.value = formPriceArea.value.replace(/[^0-9]/g, "");
            document.getElementById('priceMini').textContent = formPriceArea.value * inputArea.value;
        }
    });
}