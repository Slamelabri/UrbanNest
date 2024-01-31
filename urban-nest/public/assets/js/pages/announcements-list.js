//Modifier les filtres
const btnEditFilter = document.getElementById('btnEditFilter');
btnEditFilter.addEventListener("click", function(e){
    //Annuler l'action par default
    e.preventDefault();

});

//Filter
function checkRequires(value, min, max){
    return parseInt(value) >= min && parseInt(value) <= max;
}

function filter() {
    // Select all the announce elements
    const announces = document.querySelectorAll('#offers-list-container > article');
    let filterCount = 0;

    // Define the filter criteria
    const bathrooms = {
        min: parseInt(bathroomNumberMin.value),
        max: parseInt(bathroomNumberMax.value)
    };
    const bedrooms = {
        min: parseInt(bedroomNumberMin.value),
        max: parseInt(bedroomNumberMax.value)
    };
    const area = {
        min: parseInt(areaNumberMin.value),
        max: parseInt(areaNumberMax.value)
    };

    // Iterate over each announce and apply the filters
    announces.forEach((announce) => {
        if (!checkRequires(announce.dataset.bedrooms, bedrooms.min, bedrooms.max)) {
            announce.classList.add('announce-hide');
        } else if (!checkRequires(announce.dataset.bathrooms, bathrooms.min, bathrooms.max)) {
            announce.classList.add('announce-hide');
        } else if (!checkRequires(announce.dataset.area, area.min, area.max)) {
            announce.classList.add('announce-hide');
        } else {
            announce.classList.remove('announce-hide');
            filterCount++;
        }
    });
    document.getElementById('filterResultCounter').textContent = filterCount;
    return filterCount;
}

//Range selection
function changeInt(range, input){
    input.value = range.value;
}
function changeRange(range, input){
    range.value = input.value;
}
function syncInputAndRange(input, range){
    input.addEventListener('input', function(){
        changeRange(range, input);
        moveProgress(document.getElementById(input.dataset.rangeContainer));
    });
    range.addEventListener('input', function(){
        changeInt(range, input);
    });

    input.addEventListener('change', function(){
        filter();
    });
    range.addEventListener('change', function(){
        filter();
    });
}

//begin::Area
const areaNumberMin = document.getElementById('filter-area-input-min'), areaNumberMax = document.getElementById('filter-area-input-max');
const areaRangeMin = document.getElementById('filter-area-range-min'), areaRangeMax = document.getElementById('filter-area-range-max');

syncInputAndRange(areaNumberMin, areaRangeMin);
syncInputAndRange(areaNumberMax, areaRangeMax);
//end::Area

//begin::Bedroom
const bedroomNumberMin = document.getElementById('filter-bedroom-input-min'), bedroomNumberMax = document.getElementById('filter-bedroom-input-max');
const bedroomRangeMin = document.getElementById('filter-bedroom-range-min'), bedroomRangeMax = document.getElementById('filter-bedroom-range-max');

syncInputAndRange(bedroomNumberMin, bedroomRangeMin);
syncInputAndRange(bedroomNumberMax, bedroomRangeMax);
//end::Bedroom

//begin::Bathroom
const bathroomNumberMin = document.getElementById('filter-bathroom-input-min'), bathroomNumberMax = document.getElementById('filter-bathroom-input-max');
const bathroomRangeMin = document.getElementById('filter-bathroom-range-min'), bathroomRangeMax = document.getElementById('filter-bathroom-range-max');

syncInputAndRange(bathroomNumberMin, bathroomRangeMin);
syncInputAndRange(bathroomNumberMax, bathroomRangeMax);
//end::Bathroom

filter();

document.getElementById('btnFilter').addEventListener('click', function(e){
    e.preventDefault();
    filter();
    closeModal(document.getElementById('modalFilter'));
});

//Trier les annonces
function sortBy(sortBy) {
    // Select all the announce elements
    const container = document.querySelector('#offers-list-container');
    const announces = Array.from(container.querySelectorAll('article'));
    //Check if announces is not null
    if(announces.length > 0){
        if(sortBy === 'asc'){
            announces.sort((a, b)=> parseInt(a.dataset.price) - parseInt(b.dataset.price));
        } else {
            announces.sort((a, b)=> parseInt(b.dataset.price) - parseInt(a.dataset.price));
        }
        container.innerHTML = '';
        announces.forEach(announce => container.appendChild(announce));
    }
}

document.getElementById('selectSortBy').addEventListener('change', function(){
    sortBy(this.value);
});