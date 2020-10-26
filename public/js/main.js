console.log("main js started");


//Function to delete flash message
const flashButtons = document.querySelectorAll('.close');

// adding the event listener by looping
flashButtons.forEach(item => {
   item.addEventListener('click', (e)=>{
    flashClose = e.target.parentElement;
    flashClose.setAttribute('class', 'delete');  
   });
});

console.log("main js finished");

