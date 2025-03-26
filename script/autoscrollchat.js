    const chatContainer = document.getElementById("chatContainer");
    const messageInput = document.getElementById("message");
    const chatForm = document.getElementById("chatForm");

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    window.addEventListener('load', scrollToBottom);

    chatForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        const receiver_id = document.getElementById("receiver_id").value;
        const response_id = document.getElementById("response_id").value;

        if (message === "") return;

        try {
            const response = await fetch("../response.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `message=${encodeURIComponent(message)}&receiver_id=${receiver_id}&response_id=${response_id}`
            });

            if (response.ok) {
                const newMessage = document.createElement("div");
                newMessage.classList.add("message", "sent");
                newMessage.textContent = message;

                chatContainer.appendChild(newMessage);
                
                messageInput.value = "";
                setTimeout(scrollToBottom, 50);
                scrollToBottom();
            } else {
                console.error("Ошибка отправки сообщения.");
            }
        } catch (error) {
            console.error("Ошибка запроса:", error);
        }
    });

