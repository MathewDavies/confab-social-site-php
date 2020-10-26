"user strict";

//Count and display the characters being typed in the body box
let addPostBox = document.getElementById('add-post-body');
let addPostCount = document.getElementById('add-post-character-count');
addPostBox.addEventListener('keyup', charCount);

function charCount(){
    let count = addPostBox.value.length
    addPostCount.innerText = `${count} of 300`;
}
//Add or Remove Upvotes
let upvoteButtons = document.querySelectorAll('.like-post-button');
upvoteButtons.forEach(button => {button.addEventListener('click', addRemoveUpvote)});
upvoteNumber = document.getElementById('upvote-number');

function addRemoveUpvote(e){
    //if the parent element is currently a no class add a like
        if(e.target.matches('.upvoted-no')){
        //establish Parameters for Ajax request
        let functionPath = `${path}/posts/addReplyUpvote`;
        let postId = e.target.value;
        let postParameters = 'post_id=' + postId + 
        '&subscriber_id=' + user;
        console.log(postParameters)
        //execute Ajax request function to add like
        ajaxPostRequest(functionPath, postParameters);  
        //change classes on buttons
        e.target.classList.remove("upvoted-no");      
        e.target.classList.add("upvoted-yes");
        //change upvote count onscreen
        let containerElement = e.target.parentElement.parentElement;
        let containerElementChildren = containerElement.children;
        [].forEach.call(containerElementChildren, (child) => {
            console.log(child);
        });
        console.log(containerElement);
        console.log(containerElement.children[1].children[1].children[0].children[0]);
        let postNumberElement = containerElement.children[1].children[1].children[0].children[0];
        
        let originalPostCount = Number(postNumberElement.innerText);
        
        let NewPostCount = originalPostCount + 1;
        postNumberElement.innerText = NewPostCount;
    } else if(e.target.matches('.upvoted-yes')){
        let functionPath = `${path}/posts/removeReplyUpvote`;
        let postId = e.target.value;
        let postParameters = 'post_id=' + postId + 
                         '&subscriber_id=' + user;
        console.log(postParameters);
        ajaxPostRequest(functionPath, postParameters);
         
        //change classes on button 
        e.target.classList.remove("upvoted-yes");
        e.target.classList.add("upvoted-no");  

        //change upvote count onscreen
        let containerElement = e.target.parentElement.parentElement;
        let containerElementChildren = containerElement.children;
        [].forEach.call(containerElementChildren, (child) => {
            console.log(child);
        });
        console.log(containerElement);
        console.log(containerElement.children[1].children[1].children[0].children[0]);
        let postNumberElement = containerElement.children[1].children[1].children[0].children[0];
        
        let originalPostCount = Number(postNumberElement.innerText);
        
        let NewPostCount = originalPostCount - 1;
        postNumberElement.innerText = NewPostCount;
    }
}
