<script>
const socket = new WebSocket("ws://localhost:8080/?user_id=<?php echo $_SESSION['user']['id']; ?>");

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
    const messageInput = document.querySelector('#message');
    const message = messageInput.value;
    const responseId = document.querySelector('#response_id').value;

    const msg = {
        sender_id: <?php echo $_SESSION['user']['id']; ?>,
        receiver_id: receiverId,
        text: message,
        response_id: parseInt(responseId)
    };

    socket.send(JSON.stringify(msg));
    console.log(`Отправлено от ${msg.sender_id} для ${msg.receiver_id} (response_id: ${msg.response_id}): ${msg.text}`);

    messageInput.value = "";  
});

</script>
