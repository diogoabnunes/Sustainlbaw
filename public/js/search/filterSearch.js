function selectType(event) {

    event.preventDefault();

    let buttons = document.querySelectorAll('.type');

    buttons.forEach(button => {
        button.classList.remove('active');
        button.style.color = "#534d4e";
        button.style.background = "white";
    })

    if (!event.target.classList.contains('active')) {
        event.target.classList.add('active');
        event.target.style.color = "white";
        event.target.style.background = "#534d4e"
    }

    let elements = document.querySelectorAll('.search-container');


    console.log(event.target.getAttribute('data-id'));

    elements.forEach(element => {

        if (event.target.getAttribute('data-id') != element.id) {
            element.style.display = 'none';
        } else {
            element.style.display = 'block';
        }
    })

}