<template>
   <div class="container app">
      <div class="row app-one">
         <div class="col-sm-4 side">
            <div class="side-one">
               <div class="row heading">
                  <div class="col-sm-3 col-xs-3 heading-avatar">
                     <div class="heading-avatar-icon">
                        <img :src="owner.featured">
                         {{owner.name}}
                     </div>
                  </div>
                  <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
                     <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                  </div>
                  <div class="col-sm-2 col-xs-2 heading-compose  pull-right">
                     <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
                  </div>
               </div>

               <div class="row searchBox">
                  <div class="col-sm-12 searchBox-inner">
                     <div class="form-group has-feedback">
                        <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                     </div>
                  </div>
               </div>

               <div class="row sideBar">
                  <a href="" @click.prevent="openChat(friend)"
                     v-for="friend in friends"
                     :key="friend.id">
                     <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                           <div class="avatar-icon">
                              <img :src="friend.featured">
                              <i class="fa fa-circle fa-xs " v-if="friend.online" aria-hidden="true" :style="green">
                              </i>
                              <i class="fa fa-circle fa-xs " v-else aria-hidden="true" :style="hidden"></i>
                           </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                           <div class="row">
                              <div class="col-sm-5 col-xs-5 sideBar-name">
                                    <span class="name-meta">
                                       {{friend.name}}
                                    </span>
                              </div>
                              <div class="col-sm-3 col-xs-3 pull-right sideBar-time">
                                 <span class="badge" v-if="friend.session && (friend.session.unreadCount > 0)">
                                    {{friend.session.unreadCount}}
                                 </span>
                              </div>
                              <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                 <span class="time-meta pull-right" v-if="friend.session && (friend.session.unreadCount > 0)">
                                    {{friend.session.unreadTime}}
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
            <span v-for="friend in friends" :key="friend.id"
                  v-if="friend.session">
               <message-component
                   v-if="friend.session.open"
                   @close="close(friend)"
                   :friend="friend"
               ></message-component>
            </span>
      </div>
   </div>
</template>

<script>
    import MessageComponent from './MessageComponent';
    export default {
        data(){
          return{
             open:true,
             friends:[],
             owner:{
                name:'',
                featured:''
             },
             hidden:{
                visibility:'hidden',
                position: 'absolute',
                top: '100'
             },
             green:{
                color: 'lime',
                position: 'absolute',
                top: '100'
             }
          }
        },
        components:{MessageComponent},
        methods:{
           close(friend){
              friend.session.open=false;
           },
           getOwner(){
             axios.post('/getOwner').then(res=>{
                this.owner=res.data;
             });
           },
           getFriends(){
              axios.post('/getFriends').then(res=>{
                 this.friends=res.data.data;
                 this.friends.forEach(friend=>(
                    friend.session?this.listenForEverySession(friend):""
                   ))
              })
           },
           openChat(friend){
              if(friend.session) {
                 this.friends.forEach(friend => {
                    friend.session?friend.session.open=false:"";
                 });
                 friend.session.unreadCount = 0;
                 friend.session.open = true;
              }else{
                 this.createSession(friend)
              }
           },
           listenForEverySession(friend){
              Echo.private(`Chat.${friend.session.id}`)
                  .listen('PrivateChatEvent', (e) => {
                  friend.session.open?"":friend.session.unreadCount++;
                  friend.session.open?"":friend.session.unreadTime = e.time;
                    })
           },
           createSession(friend){
              axios.post('/session/create', {friend_id:friend.id})
                      .then(res=>{
                         friend.session=res.data.data

                         this.friends.forEach(friend => {
                             friend.session?friend.session.open=false:"";
                         });
                         friend.session.open=true
                      });
           }
        },
        created(){

           Echo.channel('Chat').listen('SessionEvent', (e)=>{
               let friend = this.friends.find(friend=>friend.id==e.session_by)
               friend.session = e.session;
               this.listenForEverySession(friend)
           });

            Echo.join('Chat')
                .here((users)=>{
                    this.friends.forEach(friend=>{
                       users.forEach(user=>{
                          if(friend.id == user.id) {
                              friend.online = true;
                         }
                       })
                    })
                })
                .joining(user=>{
                   this.friends.forEach(
                           friend=>friend.id==user.id?friend.online=true:""
                   )
                })
                .leaving(user=>{
                   this.friends.forEach(
                           friend=>friend.id==user.id?friend.online=false:""
                   )
                });
            this.getFriends();
            this.getOwner();
        }
    }
</script>
