<template>
    <div class="col-sm-8 conversation">
    <div class="row heading">
        <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
            <div class="heading-avatar-icon">
                <img :src="friend.featured">
            </div>
        </div>
        <div class="col-sm-8 col-xs-7 heading-name">
            <a class="heading-name-meta">
                <b :class="{'text-danger':session.block}">
                    {{friend.name}}
                    <span v-if="isTyping">正在輸入....</span>
                    <span v-if="session.block">(blocked)</span>

                </b>
            </a>
            <span class="heading-online">Online</span>
        </div>
        <div class="col-sm-1 col-xs-1  heading-dot pull-right">
            <a href="" @click.prevent="close">
                <i class="fa fa-times pull-right" aria-hidden="true"></i>
            </a>
            <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
            </a>
                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" @click.prevent="unblock"
                        v-if="session.block && can">
                    <i class="fa fa-unlock fa-2x" aria-hidden="true"></i>
                    </a>
                <a class="dropdown-item" href="#" @click.prevent="block"
                        v-if="!session.block">
                    <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                </a>
                <a class="dropdown-item" href="#" @click.prevent="clear">
                    <i class="fa fa-eraser fa-2x" aria-hidden="true"></i>
                </a>
            </div>
    </div>
    </div>

    <div class="row message" id="conversation"  v-chat-scroll>
        <div class="row message-previous">
            <div class="col-sm-12 previous">
                <a onclick="previous(this)" id="ankitjain28" name="20">
                    Show Previous Message!
                </a>
            </div>
        </div>
            <div class="row message-body"
                 v-for="chat in chats" :key="chat.id">
                <div :class="(chat.type == 0)?'col-sm-12 message-main-sender':'col-sm-12 message-main-receiver'">
                    <div :class="(chat.type == 0)?'sender':'receiver'">
                        <div class="message-text">
                            {{chat.message}}
                        </div>
                        <span class="message-read" v-if="chat.read_at != null">
                            已讀
                        </span>
                        <span class="message-time">
                            {{chat.send_at}}
                        </span>
                    </div>
                </div>
            </div>
    </div>
       <form @submit.prevent="send">
        <div class="row reply">
            <div class="col-sm-1 col-xs-1 reply-emojis">
                <i class="fa fa-smile-o fa-2x"></i>
            </div>
            <div class="col-sm-9 col-xs-9 reply-main">
                <input class="form-control"  id="comment"
                       :disabled="session.block"
                       v-model="message"
                       placeholder="write your message here">
            </div>
            <div class="col-sm-1 col-xs-1 reply-recording">
                <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
            </div>
            <div class="col-sm-1 col-xs-1 reply-send">
                <button type="submit" class="btn-link">
                <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </form>
    </div>
</template>


<script>
    export default {
        props:['friend'],
        data(){
          return{
              chats:[],
              session_block:false,
              message:"",
              isTyping:false
          }
        },
        computed:{
          session(){
              return this.friend.session;
          },
          can(){
              return this.session.blocked_by == auth.id;
          }
        },
        watch:{
            message(value){
                if(value){
                    Echo.private(`Chat.${this.friend.session.id}`)
                        .whisper('typing',{
                            name:auth.name
                        })
                }
            }
        },
        methods:{
            send(){
                if(this.message){
                    this.pushToChats(this.message)
                    axios.post(`send/${this.friend.session.id}`,{
                        content:this.message,
                        to_user:this.friend.id
                    })
                    .then(res=>{
                        this.chats[this.chats.length-1].id = res.data[0];
                        this.chats[this.chats.length-1].send_at = res.data[1];
                    })
                    this.message=null;
                }
            },
            pushToChats(message){
                this.chats.push({message:message, type:0, read_at:null, send_at:'just_now'});
            },
            close(){
                this.$emit('close');
            },
            clear(){
                axios.post(`/session/${this.friend.session.id}/clear`)
                    .then(res=>(this.chats=[]))

            },
            block(){
                this.session.block=true;
                axios.post(`/session/${this.friend.session.id}/block`)
                    .then(res=>(this.session.blocked_by = auth.id))
            },
            unblock(){
                this.session.block=false;
                axios.post(`/session/${this.friend.session.id}/unblock`)
                    .then(res=>(this.session.blocked_by = null))
            },
            getAllMessages(){
                axios.post(`/session/${this.friend.session.id}/chats`)
                    .then(res=>{
                        this.chats=res.data.data
                    })
            },
            read(){
                axios.post(`/session/${this.friend.session.id}/read`)
            }
        },
        created() {
           this.getAllMessages();
           this.read();
           Echo.private(`Chat.${this.friend.session.id}`)
               .listen('PrivateChatEvent', (e)=>{
                   this.friend.session.open?this.read():"";
                   this.chats.push({message:e.content, type:1, send_at:e.time});
           });

          Echo.private(`Chat.${this.friend.session.id}`)
              .listen('MsgReadEvent', (e)=>{
              console.log(e)
              this.chats.forEach(chat=>(chat.id == e.chat.id?(chat.read_at = e.chat.read_at):""))
          });

           Echo.private(`Chat.${this.friend.session.id}`)
                .listen('BlockEvent', (e)=>{
                   this.session.block = e.blocked;
           });

           Echo.private(`Chat.${this.friend.session.id}`)
               .listenForWhisper("typing",(e)=>{this.isTyping = true
                    setTimeout(()=>{
                        this.isTyping = false
                    }, 5000)
               })
        }
    }
</script>