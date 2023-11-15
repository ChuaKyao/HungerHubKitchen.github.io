let profile = document.querySelector('.profile');

document.querySelector('#header-btn1').onclick = () =>{
   profile.classList.toggle('active');
   document.body.classList.remove('display-chatbot');
}

function loader(){
   document.querySelector('.loader').style.display = 'none';
}

// notice 1000 = 1seconds
// so 2000 = 2seconds

function fadeOut(){
   setInterval(loader, 2000)
}

window.onload = fadeOut;

// //AI chat bot
// const chatInput = document.querySelector(".chat-input textarea");
// const sendChatBtn = document.querySelector(".chat-input span");
// const chatbox = document.querySelector(".chatbox");
const chatbotToggler = document.querySelector(".chatbot-toggler");
const chatbotCloseBtn = document.querySelector(".close-btn");

// let userMessage;
// const API_KEY = "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";
// const inputInitHeight = chatInput.scrollHeight;

// const createChatLi = (message, className) => {
//     // A chat <li> element with passed message and className
//     const chatLi = document.createElement("li");
//     chatLi.classList.add("chat", className);
//     let chatContent = className === "outgoing" ? `<p></p>` : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
//     chatLi.innerHTML = chatContent;
//     chatLi.querySelector("p").textContent = message;
//     return chatLi;
// }

// const generateResponse = (incomingChatLi) => {
//     const API_URL = "https://api.openai.com/v1/chat/completions";
//     const messageElement = incomingChatLi.querySelector("p");

//     const requestOptions = {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "Authorization": `Bearer jQuery{API_KEY}`
//         },
//         body: JSON.stringify({
//             model: "gpt-3.5-turbo",
//             messages: [{role: "user", content: userMessage}]
//         })  
//     }

//     //send POST request to API, get response
//     fetch(API_URL, requestOptions).then(res => res.json()).then(data => {
//         messageElement.textContent = data.choices[0].message.content;
//     }).catch((error) => {
//         messageElement.classList.add("error");
//         messageElement.textContent = "Oops! Something went wrong. Please try again.";
//     }).finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));

// }

// const handleChat = () => {
//     userMessage = chatInput.value.trim();
//     if(!userMessage) return;
//     chatInput.value = "";
//     chatInput.style.height = `jQuery{inputInitHeight}px`;

//     // Append user's message to the chatbox
//     chatbox.appendChild(createChatLi(userMessage, "outgoing"));
//     chatbox.scrollTo(0, chatbox.scrollHeight);

//     setTimeout(() => {
//         // To display thinling message while waiting for response
//         const incomingChatLi = createChatLi("Thinking...", "incoming")
//         chatbox.appendChild(incomingChatLi);
//         chatbox.scrollTo(0, chatbox.scrollHeight);
//         generateResponse(incomingChatLi);
//     },600);
// }

// chatInput.addEventListener("input", () => {
//     chatInput.style.height = `jQuery{inputInitHeight}px`;
//     chatInput.style.height = `jQuery{chatInput.scrollHeight}px`;
// });

// chatInput.addEventListener("keydown", (e) => {
//     if(e.key === "Enter" && !e.shiftKey && window.innerWidth > 800){
//         e.preventDefault();
//         promptAi();
//     }
// });

// sendChatBtn.addEventListener("click", handleChat);
chatbotCloseBtn.addEventListener("click", () => document.body.classList.remove("display-chatbot"));
chatbotToggler.addEventListener("click", () => {
    document.body.classList.toggle("display-chatbot");
    document.querySelector('.profile').classList.remove('active');
});

jQuery("#prompt").keydown(function(event){
    if(event.key == "Enter"){
        promptAi();
    }
})
let canSend = true;

function promptAi(){
    if(canSend){
        let jQueryelement = jQuery(".chatbox");
        canSend = false;
        jQuery("#promptButton").attr("onclick","");
        let prompt = jQuery("#prompt").val();
        console.log(prompt);
        jQuery("#prompt").val("");
        jQuery(".chatbox").append(`<div class="d-flex justify-content-end prompt my-2">
            <div class="p-1 col-8 mx-2">
                <span>${prompt}</span>
            </div>
        </div>`);
        jQueryelement.scrollTop(jQueryelement.prop("scrollHeight"));

        jQuery.ajax({
            type: "POST",
            data: {
                prompt: prompt
            },
            url: "Bot.php",
            success: function(data){
                console.log(data)
                jQuery("#promptButton").attr("onclick","promptAi()");
                canSend = true;
                let max = data.length + 1;
                let count = 0;

                jQuery(".chatbox").append(`<li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p class="res"></p>
            </li>`);

                let print = setInterval(() => {
                    jQuery(".res").last().html(`<spans>${data.substring(0,count)}</spans>`);

                    jQueryelement.scrollTop(jQueryelement.prop("scrollHeight"));

                    if(count + 1 == max){
                        clearInterval(print);
                    }
                    count++;
                },10);
            },
            error: function(xhr, status, error){

            }
        });
    }
}