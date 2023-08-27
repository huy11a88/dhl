const currentChatUserId = Number(document.getElementById('chat-box')?.getAttribute('data-user-id'));

const applyComment = (comment) => {
    const commentTemplate = `<div class="flex gap-4 items-start mb-5">
            <div class="flex justify-center items-center rounded-full text-white bg-yellow-500 w-10 h-10 font-medium">:avatar</div>
            <div class="flex flex-col grow">
                <p class="flex gap-2 items-center">
                    <span class="font-medium">:user_name</span>
                    <small class="text-gray-500">:time</small>
                </p>
                <p>:comment</p>
            </div>
        </div>`;
    
    return commentTemplate.replace(':avatar', comment.avatar)
                .replace(':user_name', comment.user_name)
                .replace(':time', comment.time)
                .replace(':comment', comment.comment);
}

const applyChat = (chat, userId) => {
   const chatTemplate = `<div class="flex gap-3:position">
                <div class="flex justify-center items-center rounded-full text-white bg-yellow-400 w-10 h-10 font-medium">:avatar</div>
                <div class="rounded-3xl text-gray-600 w-fit max-w-[70%] break-words py-2 px-5 bg-slate-100">:message</div>
            </div>`;

    return chatTemplate.replace(':avatar', chat.avatar)
                .replace(':message', chat.message)
                .replace(':position', chat.user_id === userId ? ' flex-row-reverse' : '')
}

const loadChat = (userId) => {
    axios({
        method: 'get',
        url: `/chat-message/${userId}`
    })
        .then((res) => {
            for (const chat of res.data.chats) {
                document.getElementById('chat-box-content').insertAdjacentHTML('beforeend', applyChat(chat, currentChatUserId));
            }
            scrollChatToBottom();
        });
}

const scrollChatToBottom = () => {
    const chatboxElement = document.getElementById('chat-box-content');
    chatboxElement.scrollTo({
        top: chatboxElement.scrollHeight,
        behavior: "smooth"
    });
}

const loadComments = (comments) => {
    const commentContainer = document.getElementById('comment-list');
    const totalElement = document.getElementById('total-comment');

    if (Array.isArray(comments)) {
        // load all comments
        if (comments.length === 0) {
            commentContainer.insertAdjacentHTML('beforeend', '<p id="no-comment" class="text-center">There is no reviews yet</p>');
            return;
        }

        let commentHtml = '';
        totalElement.textContent = comments.length;
        for (const comment of comments) {
            commentHtml += applyComment(comment);
        }
        commentContainer.insertAdjacentHTML('beforeend', commentHtml);
    } else {
        // append new comment
        totalElement.textContent = Number(totalElement.textContent) + 1;
        document.getElementById('no-comment')?.remove();
        commentContainer.insertAdjacentHTML('beforeend', applyComment(comments));
    }
}

document.getElementById('add-review')?.addEventListener('submit', function (e) {
    e.preventDefault();

    axios({
        method: 'post',
        url: '/orders/review',
        data: new FormData(this)
    })
        .then((res) => {
            this.reset();
            loadComments(res.data.review);
        })
        .catch((err) => {
            console.log(err.response)
        });

});

document.querySelector('#chat-box-header > button')?.addEventListener('click', function () {
    document.getElementById('chat-box').classList.add('hidden');
    document.getElementById('chat-box-icon').classList.remove('hidden');
});

document.getElementById('chat-box-icon')?.addEventListener('click', function () {
    document.getElementById('chat-box-icon').classList.add('hidden');
    document.getElementById('chat-box').classList.remove('hidden');

    if (document.getElementById('chat-box-content').hasChildNodes()) {
        scrollChatToBottom();
    } else {
        loadChat(currentChatUserId);
    }
});

document.querySelector('#add-review textarea')?.addEventListener('input', function () {
    const btn = this.nextElementSibling;

    if (this.value) {
        btn.disabled = false;
        btn.classList.add('bg-yellow-400');
        btn.classList.remove('bg-yellow-400/60');
    } else {
        btn.disabled = true;
        btn.classList.add('bg-yellow-400/60');
        btn.classList.remove('bg-yellow-400');
    }
});

document.querySelectorAll('.toggle').forEach((el) => {
    el.addEventListener('click', function () {
        const content = this.nextElementSibling;
        content.classList.toggle('hidden');
        if (content.classList.contains('hidden')) {
            this.querySelector('.angle-up').classList.remove('hidden');
            this.querySelector('.angle-down').classList.add('hidden');
        } else {
            this.querySelector('.angle-up').classList.add('hidden');
            this.querySelector('.angle-down').classList.remove('hidden');
        }
    });
});

document.getElementById('update-order-status')?.addEventListener('change', function () {
    const select = this.querySelector('select');
    const btn = this.querySelector('button');

    if (select.value === select.firstElementChild.getAttribute('value')) {
        btn.disabled = true;
        btn.classList.add('bg-green-500/60');
        btn.classList.remove('bg-green-500');
    } else {
        btn.disabled = false;
        btn.classList.add('bg-green-500');
        btn.classList.remove('bg-green-500/60');
    }
});

document.getElementById('chat-message')?.addEventListener('keyup', function (e) {
    if (e.code === 'Enter') {
        axios({
            method: 'post',
            url: '/new-message',
            data: {
                room_user_id: document.getElementById('chat-box').getAttribute('data-room-user-id'),
                message: this.value
            }
        })
            .then(() => {
                document.getElementById('chat-message').value = '';
                scrollChatToBottom();
            });
    }
});

document.querySelectorAll('[id^=room-]').forEach((el) => {
    el.addEventListener('click', function () {
        const chatboxContent = document.getElementById('chat-box-content');
        while (chatboxContent.firstChild) {
            chatboxContent.removeChild(chatboxContent.firstChild);
        }
        const roomUserId = this.getAttribute('data-user-id');
        document.getElementById('chat-box').setAttribute('data-room-user-id', roomUserId);
        document.getElementById('chat-name').textContent = this.getAttribute('data-user-name');
        loadChat(roomUserId)
    });
});

Echo.channel('chat')
    .listen('NewMessageChat', (e) => {
        document.getElementById('chat-box-content').insertAdjacentHTML('beforeend', applyChat(e.data, currentChatUserId));
        scrollChatToBottom();
    });

onload = () => {
    if (/^\/orders\/\d+/.test(location.pathname)) {
        const orderId = document.querySelector('[data-order-id]').getAttribute('data-order-id');

        axios({
            method: 'get',
            url: `/orders/review/${orderId}`
        })
            .then((res) => {
                loadComments(res.data.reviews);
            })
    }

    if (/^\/customer-service/.test(location.pathname)) {
        document.querySelector('[id^=room-]').click();
    }
}