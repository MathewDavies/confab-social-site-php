console.log("login js load started")

//Slide the login/register back and forth on click
const x= document.getElementById('login');
const y= document.getElementById('register');
const z= document.getElementById('btn');

function displayRegister(){
    x.style.left = "-400px";
    y.style.left = "50px";
    z.style.left ="110px";
}

function displayLogin(){
    x.style.left = "50px";
    y.style.left = "450px";
    z.style.left ="0px";
}

// Function to reset to register side is displayed on reloaded after the php register button is pressed
if (side==="register"){
    displayRegister();
} else {
    console.log("normal");
}

document.getElementById('form-box').style.display='block';

console.log("login js load started")
//###Validation for forms

//###Warning I have taken out the connection to the register function from the button on the view

//     let name = document.getElementById("register-name");
//     let email = document.getElementById("register-email");
//     let password = document.getElementById("register-password");
//     let confirm = document.getElementById("register-confirm");
//     let type = 'register';
//     //variables for each error field
//     let nameError = document.getElementById("name-error");
//     let emailError = document.getElementById("email-error");
//     let passwordSizeError = document.getElementById("size-error");
//     let passwordNumberError = document.getElementById("number-error");
//     let passwordCapsError = document.getElementById("caps-error");
//     let passwordSymbolError = document.getElementById("symbol-error");
    
//     let passwordSizeErrorTick = document.getElementById("size-error-tick");

//     let confirmError = document.getElementById("confirm-error");
//     //event listeners for each input field
//     let validName = false;
//     let validEmail = false;
//     let validPassword = false;
//     let validConfirm = false;
//     //event listeners for each input field
//     name.addEventListener('blur', validateName);
//     email.addEventListener('blur', validateEmail);
//     password.addEventListener('keyup', validatePassword);
//     confirm.addEventListener('keyup', validateConfirm);
    
//     //Is there a user name?
//     function validateName(){
//         if(!name.value){
//             nameError.style.display = "block";
            
//             validName = false;
//         } else{
//             nameError.style.display = "none";
//             validName= true;
//         }
//     }
        
//     //Is there a valid email?
//     function validateEmail(){
//         const expression = /\S+@\S+/ // put in dot validation
//         if(!expression.test(String(email.value).toLowerCase())) {
//             emailError.style.display = "block";
//             validEmail = false;
            
//         }else{
//             emailError.style.display = "none";
//             validEmail = true;
//         }
//     }
//     //password has a number, a capital and a symbol
//    function validatePassword() {
//     console.log("validate password");
//     let size = password.value.length;
//     let numbers = password.value.match(/\d+/g);
//     let caps  = password.value.match(/[A-Z]/);
//     let symbol = password.value.match(/[!@#$%\^&*\+]/);
    
//     if (numbers==null){
//         passwordNumberError.style.color = "grey";
//     }else{
//         passwordNumberError.style.color = "blue";
//     }
//     if (caps==null){
//         passwordCapsError.style.color = "grey";
//     }else{
//         passwordCapsError.style.color = "blue";
//     }
//     if (symbol==null){
//         passwordSymbolError.style.color = "grey";
//     }else{
//         passwordSymbolError.style.color = "blue";
//     }
//     if (size< 6){
//         passwordSizeError.style.color = "grey";
        
//     }else{
//         passwordSizeError.style.color = "blue";
        
//     }
//     if (numbers === null || caps === null || symbol === null){
//         validPassword = false;
//     }else{
//         validPassword = true; 
//     } 
// }

//     function validateConfirm(){
//         if(password.value === confirm.value){
//             confirmError.style.color = "blue";
//             console.log(password.value +  " " + confirm.value);
//             validConfirm = true;
//         }else{
//             confirmError.style.color = "grey";
//             console.log(password.value +  " " + confirm.value);
//             validConfirm = false;
//         }
//     }

//     function register(){
//         if(validName==false ||
//            validEmail==false ||
//            validPassword==false ||
//            validConfirm==false
//            ){

//             alert("Please check your answers.")
//         }else{
//                console.log("information okay");

//         //Send AJAX request to register data and get a success or failure reply in response text       
//         const request = new XMLHttpRequest();
            
//         request.onload = () => {
           
//           let responseData = "";
//           console.log('response text is: ' + request.responseText);

//            responseData = request.responseText
//            console.log(responseData); 
//             //if registered, reset the form
//             if(responseData.includes('success')){
                
//                 //remove the values from the form
//                 name.value = "";
//                 email.value = "";
//                 password.value = "";
//                 confirm.value = "";

//                 //reset the validation variables and turn display grey again
//                 nameError.style.display = "none";
//                 nameError.style.display = "none";
//                 validName = false;
//                 validEmail = false;
//                 validatePassword();
//                 validateConfirm();
//                 //alert success
//                 alert('You are registered');
//             }else{
//                 alert('please check your answers');
//             }

            
//         };

//         const postInfo = 'register-name=' + name.value + 
//                          '&register-email= ' + email.value + 
//                          '&register-password=' + password.value + 
//                          '&register-confirm= ' + confirm.value + 
//                          '&type = ' + type ;

//         request.open('post', 'http://localhost/frameworkfiddle/users/register');
//         request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//         request.send(postInfo);       
//         }
//     }

    
     

