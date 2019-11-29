function handlerAddMessage(event){
    const input = event.currentTarget.previousElementSibling;

    const p = document.createElement('p');
    p.textContent = input.value;

    document.getElementById('chatTextarea').append(p);

    input.value ='';
}

document.querySelector('.form > button').addEventListener('click', handlerAddMessage);

