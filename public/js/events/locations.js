let district = document.getElementById('select-district');
let county = document.getElementById('select-county');
let parish = document.getElementById('select-parish');

district.addEventListener('change', (e) => {
    e.preventDefault();
    console.log(e.target.value);

    sendAjaxRequest('get', `/api/locations/${e.target.value}`, null, getCountiesHandler);
})

county.addEventListener('change', (e) => {
    e.preventDefault();

    sendAjaxRequest('get', `/api/locations/${district.value}/${e.target.value}`, null, getParishesHandler);
    console.log(e.target.value);

})


function getCountiesHandler() {
    let data = JSON.parse(this.responseText);

    county.innerHTML = `<option disabled selected>Selecione o concelho</option>`;
    parish.innerHTML = `<option disabled selected>Selecione primeiro o concelho</option>`;

    data.counties.forEach(newCounty => {

        let option = document.createElement('option');
        option.innerText = newCounty.county;
        option.value = newCounty.county;

        county.appendChild(option);
    });


}


function getParishesHandler() {
    let data = JSON.parse(this.responseText);
    console.log(data)

    parish.innerHTML = `<option disabled selected>Selecione a freguesia</option>`;

    data.parishes.forEach(newParish => {

        let option = document.createElement('option');
        option.innerText = newParish.parish;
        option.value = newParish.dcp_id;

        parish.appendChild(option);
    });

}