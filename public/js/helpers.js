//Ajax Helper function
    
function ajaxPostRequest(functionPath, postParameters){

    const request = new XMLHttpRequest();
      request.onload = () => {
    result = request.responseText;
      console.log(request.responseText);
      return result;      
    } 
        
    request.open('post', functionPath);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(postParameters); 
}