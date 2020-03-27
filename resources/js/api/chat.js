import axios from 'axios';

export default {
    fetchChats() {
        return axios.get('/api/v1/chats');
    },
    fetchChatMessages(chatId) {
        return axios.get('/api/v1/chats/' + chatId + '/messages');
    },
    sendMessage(chatId, data) {
        return axios.post('/api/v1/chats/' + chatId + '/messages', data);
    }
}
