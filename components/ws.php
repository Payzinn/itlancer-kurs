<script>
const socket = new WebSocket("ws://localhost:8080?user_id=<?php echo $_SESSION['user']['id']; ?>"); 

socket.onopen = () => console.log("Подключено к WebSocket!");

socket.onmessage = (event) => {
    const data = JSON.parse(event.data);
    const chatBlock = document.querySelector('.chat_block');
    const messageDiv = document.createElement('div');
    messageDiv.textContent = `${data.from}: ${data.text}`;
    chatBlock.appendChild(messageDiv);
};

document.querySelector('#chatForm').addEventListener('submit', (e) => {
    e.preventDefault();  

    const receiverId = document.querySelector('#receiver_id').value;  
    const message = document.querySelector('#message').value;

    const msg = {
        sender_id: <?php echo $_SESSION['user']['id']; ?>,  
        receiver_id: receiverId,
        text: message
    };

    socket.send(JSON.stringify(msg)); 
    console.log(`Отправлено от ${msg.sender_id} для ${msg.receiver_id}: ${msg.text}`);
});
</script>