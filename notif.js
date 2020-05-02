$(document).ready(function(){
Array.from(document.querySelectorAll('input[type="submit"].request')).forEach(request => {
    request.addEventListener('click', (e)=> {
        e.preventDefault();

        let buddyID = e.target.parentNode.querySelector('.buddyID').value;

        console.log(buddyID);
    })
})
})