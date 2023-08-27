import axios from "axios";
import { loadChat, scrollChatToBottom, applyChat } from "./main";

axios({
    method: 'get',
    url: '/chat-rooms/all'
})
    .then((res) => {
        const currentChatUserId = Number(document.getElementById('chat-box').getAttribute('data-user-id'))
        for (const room of res.data.chat_rooms) {
            Echo.join(`chat.${room.id}`)
                .listen('NewMessage', (e) => {
                    const activeRoomId = document.getElementById('chat-message').getAttribute('data-chat-room-id');
                    if (e.chat.chat_room_id != activeRoomId) {
                        return;
                    }
                    document.getElementById('chat-box-content').insertAdjacentHTML('beforeend', applyChat(e.chat, currentChatUserId));
                    scrollChatToBottom();
                });
        }
        document.querySelector('[id^=room-]')?.click();
    })

Echo.channel('new-room')
    .listen('NewRoom', (e) => {
        const room = e.data;
        document.getElementById('no-rooms').remove();
        const roomTemplate = `<div id="room-${room.user_id}" class="flex gap-3 cursor-pointer" data-user-id="${room.user_id}" data-user-name="${room.user_name}" data-room-id="${room.room_id}" >
                <div class="flex justify-center items-center rounded-full text-white bg-yellow-500 w-10 h-10 font-medium">${room.avatar}</div>
                <div class="flex flex-col grow">
                    ${room.user_name}
                </div>
            </div>`;
        document.getElementById('rooms-list').insertAdjacentHTML('beforeend', roomTemplate);
    });

document.querySelectorAll('[id^=room-]').forEach((el) => {
    el.addEventListener('click', function () {
        const chatboxContent = document.getElementById('chat-box-content');
        while (chatboxContent.firstChild) {
            chatboxContent.removeChild(chatboxContent.firstChild);
        }
        const roomId = this.getAttribute('data-room-id');
        document.getElementById('chat-name').textContent = this.getAttribute('data-user-name');
        document.getElementById('chat-message').setAttribute('data-chat-room-id', roomId);
        loadChat(roomId)
    });
});
