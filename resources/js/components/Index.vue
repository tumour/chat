<template>
    <div class="container">
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar"  placeholder="Search" />
                                <span class="input-group-addon">
                                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="inbox_chat">
                        <div class="chat_list"
                             v-bind:class="{ 'active_chat' : selectedChat.id === chat.id }"
                             v-for="chat in chats"
                             :key="chat.id"
                             @click="chooseChat(chat)">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <default-avatar
                                        :color="chat.avatar_color"
                                        :svg-text="chat.name">
                                    </default-avatar>
                                </div>
                                <div class="chat_ib">
                                    <h5>{{ chat.name }} <span class="chat_date">{{ chat.last_message_at ? getLastMessageAt(chat.last_message_at) : getLastMessageAt(chat.created_at) }}</span></h5>
                                    <p>{{ chat.last_message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mesgs">
                    <div class="msg_history">
                        <div v-bind:class="[isAuthUserMessage(message.user) ? 'outgoing_msg' : 'incoming_msg']"
                             v-for="message in messages" :key="message.id">
                            <div class="incoming_msg_img" v-if="! isAuthUserMessage(message.user)">
                                <default-avatar
                                    :color="message.user.avatar_color"
                                    :svg-text="message.user.name">
                                </default-avatar>
                            </div>
                            <div v-bind:class="[isAuthUserMessage(message.user) ? 'sent_msg' : 'received_msg']">
                                <div v-bind:class="[! isAuthUserMessage(message.user) ? 'received_withd_msg' : '']">
                                    <p>{{ message.message }}</p>
                                    <span class="time_date"> {{ getMessageAt(message.created_at) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input
                                type="text"
                                class="write_msg"
                                placeholder="Type a message"
                                v-model="newMessage"
                                @keyup.enter="sendMessage(selectedChat)" />
                            <button
                                class="msg_send_btn"
                                type="button"
                                @click="sendMessage(selectedChat)">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Chats from "./Chats";
    import DefaultAvatar from "./DefaultAvatar";

    import ApiChat from './../api/chat';
    import moment from "moment";

    export default {
        components: { DefaultAvatar, Chats },
        data() {
            return {
                chats: [],
                messages: [],
                selectedChat: {},
                newMessage: null
            }
        },
        mounted() {
            this.$watch('selectedChat', function () {
                Echo.private(`chat.${this.selectedChat.id}`)
                    .listen('MessageSent', (data) => {
                        console.log(data);
                    });
            });
        },
        created() {
            this.fetchChats();
        },
        methods: {
            fetchChats() {
                ApiChat.fetchChats().then((response) => {
                    this.chats = response.data.data;
                });
            },
            getLastMessageAt(date) {
                return moment(date).format('DD/MM/YYYY');
            },
            getMessageAt(date) {
                return moment(date).format('DD.MM HH:mm')
            },
            fetchChatMessages(chat) {
                ApiChat.fetchChatMessages(chat.id).then((response) => {
                    this.messages = response.data.data;
                });
            },
            chooseChat(chat) {
                this.selectedChat = chat;

                this.fetchChatMessages(chat);
            },
            isEmptySelectedChat() {
                return _.isEmpty(this.selectedChat);
            },
            sendMessage(chat) {
                let data = {
                    message: this.newMessage,
                }

                if (this.newMessage) {
                    ApiChat.sendMessage(chat.id, data).then((response) => {

                    });
                }
            },
            isAuthUserMessage(messageUser) {
                return auth.user.id === messageUser.id;
            }
        },
    }
</script>
