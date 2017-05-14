<template>
    <div class="xxim_main">
      <div class="xxim_header">
        <h2>通知</h2>
        <md-button class="md-icon-button md-primary" :class="{ tip_msg:  hasMsg.isTwinkling && !hasMsg.isExpanding}" style="color: #32cd32;">
          <md-icon>add_alert</md-icon>
        </md-button>
        <md-button md-theme="md-transparent" class="md-icon-button md-primary expand" @click.native="expand()" v-hidden>
          <md-icon>expand_less</md-icon>
        </md-button>
      </div>

      <div class="xxim_message">
        <ul v-enter>
          <li :class="{ xxim_chatme: (message.unique_id == unique_id) }" v-for="message in messages">
            <div class="xxim_chatuser">
              <span class="xxim_chatname" v-if="! (message.unique_id == unique_id)">{{ message.user }}</span>
              <span class="xxim_chattime" v-if="! (message.unique_id == unique_id)">{{ message.time }}</span>
              <span class="xxim_chattime" v-if="(message.unique_id == unique_id)">{{ message.time }}</span>
              <span class="xxim_chatname" v-if="(message.unique_id == unique_id)">{{ message.user }}</span>
            </div>
            <div class="xxim_chatsay">{{ message.msg }} <em class="xxim_zero"></em></div>
          </li>
        </ul>
      </div>

      <section>
        <form novalidate @submit.stop.prevent="send" class="xxim_bottom" md-column>
          <md-layout md-gutter>
            <md-layout md-flex="75">
              <div class="tip" v-show="!isValidate">说点啥好呢？ <em class="tip_zero"></em></div>
              <input class="textarea" v-model="msg" v-focus/>
            </md-layout>
            <md-layout md-flex="25">
              <md-button class="md-raised" type="submit">发送</md-button>
            </md-layout>
          </md-layout>
        </form>
      </section>

      <section v-if="video.first">
        <v-video :muted="video.muted" :show="video.show" :play="video.play"></v-video>
      </section>
    </div>
</template>

<style scoped>
    h2, div, section {
        margin: 0;
        padding: 0;
    }

    ::-webkit-scrollbar {
        width: 10px;
    } /* 这是针对缺省样式 (必须的) */

    ::-webkit-scrollbar-track {
        background-color: #ffffff;
    } /* 滚动条的滑轨背景颜色 */

    ::-webkit-scrollbar-thumb {
        background-color: #D0DCF3;
    } /* 滑块颜色 */

    .xxim_main {
        position: fixed;
        right: 1px;
        bottom: -500px;
        width: 400px;
        border: 1px solid #BEBEBE;
        border-radius: 10px 0 0 0;
        background-color: #ffffff;
        font-size: 12px;
        box-shadow: 0 1px 5px rgba(0,0,0,.2), 0 2px 2px rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.12);
        z-index: 1989;
        transition: bottom 0.6s ease-out;
    }

    .xxim_header {
        height: 40px;
        background-color: #ffffff;
        border-radius: 10px 0 0 0;
        border-bottom: 1px solid #DCDCDC;
    }

    .xxim_header h2 {
        line-height: 40px;
        display: inline;
        padding-left: 13px;
    }

    .xxim_header .expand {
        float: right;
    }

    @-webkit-keyframes twinkling {	/*透明度由0到1*/
        0%{
            opacity:0;				/*透明度为0*/
        }
        100%{
            opacity:1;				/*透明度为1*/
        }
    }

    .xxim_header .tip_msg {
        animation: twinkling 1s infinite ease-in-out;
    }

    .xxim_bottom {
        height: 50px;
        border-top: 1px solid #D0DCF3;
        background-color: #F2F4F8;
        z-index: 1999;
    }

    .tip {
        position: fixed;
        float: left;
        bottom: 55px;
        margin: 0 15px;
        padding: 10px;
        line-height: 20px;
        color: #ffffff;
        background-color: #ff5722;
        border-radius: 3px;
        clear: both;
    }

    .tip_zero {
        right: 10px;
        left: 5px;
        bottom: -15px;
        border-width: 15px;
        position: absolute;
        width: 0;
        height: 0;
        border-style: dashed;
        border-color: transparent;
        overflow: hidden;
        border-right-color: #ff5722;
        border-right-style: solid;
    }

    .textarea {
        width: 100%;
        margin: 6px 8px;
        padding: 0 10px 0 10px;
        font-size: 16px;
        background-clip: padding-box;
        border-radius: 10px;
        border: 2px solid #F2F4F8;
        box-shadow: 0 1px 5px rgba(0,0,0,.2), 0 2px 2px rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.12);
    }

    .textarea:focus {
        outline: none;
        border-color: #3A4BAD;
        transition: all .4s cubic-bezier(.25,.8,.25,1);
    }

    .xxim_message {
        height: 450px;
        overflow: hidden;
    }

    ul {
        display: block;
        height: 450px;
        overflow: hidden;
        padding: 0;
        margin: 0;
    }

    ul li {
        margin-bottom: 10px;
        clear: both;
        list-style: none;
    }

    ul li:after {
        content: '\20';
        clear: both;
        display: block;
        height: 0;
    }

    .xxim_chatuser .xxim_chatname {
        max-width: 230px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .xxim_chatuser * {
        display: inline-block;
        vertical-align: top;
        line-height: 30px;
        font-size: 12px;
        padding-right: 10px;
    }

    .xxim_chatme .xxim_chatuser {
        float: right;
    }

    .xxim_chatuser {
        float: left;
        padding: 15px;
        font-size: 0;
    }

    .xxim_chatme .xxim_chatuser .xxim_chattime {
        padding-left: 0;
        padding-right: 10px;
    }

    .xxim_chatme .xxim_chatuser * {
        padding-right: 0;
        padding-left: 10px;
    }

    .xxim_chatuser .xxim_chattime {
        color: #999;
        padding-left: 10px;
    }

    .xxim_chatuser * {
        display: inline-block;
        vertical-align: top;
        line-height: 30px;
        font-size: 12px;
        padding-right: 10px;
    }

    .xxim_chatme .xxim_chatsay {
        float: right;
        background-color: #EBFBE3;
    }

    .xxim_chatsay {
        position: relative;
        float: left;
        margin: 0 15px;
        padding: 10px;
        line-height: 20px;
        background-color: #F3F3F3;
        border-radius: 3px;
        clear: both;
    }

    .xxim_chatme .xxim_chatsay .xxim_zero {
        left: auto;
        right: 10px;
    }

    .xxim_chatme .xxim_zero {
        border-right-color: #EBFBE3;
    }

    .xxim_chatsay .xxim_zero {
        left: 5px;
        top: -8px;
        border-width: 8px;
        border-right-style: solid;
        border-right-color: #F3F3F3;
    }

    em {
        font-style: normal;
        font-weight: 400;
    }

    .xxim_zero {
        position: absolute;
        width: 0;
        height: 0;
        border-style: dashed;
        border-color: transparent;
        overflow: hidden;
    }
</style>

<script type="es6">
    import vVideo from './Video.vue'
    export default{
        props: [ 'unique_id_key' ],

        components: {
            vVideo
        },

        data() {
            return {
                unique_id: '',
                msg: '',
                isValidate: true,


                hasMsg: {
                    isTwinkling: false,
                    isExpanding: false,
                },

                video: {
                    play: '',
                    first: false,
                    show: false,
                    muted: false,
                },
                messages: [
//                    { user: '游客', me: true, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: false, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: true, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: false, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: true, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: false, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: false, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: true, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: true, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: false, msg: '请问您想干什么？', time: new Date().toLocaleString() },
//                    { user: '游客', me: true, msg: '请问您想干什么？', time: new Date().toLocaleString() },
                ]
            }
        },

        vuerify: {
            msg: [ 'required' ],
        },

        computed: {
            validate() {
                return this.$vuerify.check()
            }
        },

        methods: {
            send() {
                if (!this.validate) {
                    this.isValidate = false
                    setTimeout(() => {
                        this.isValidate = true
                    }, 3000)
                    return ;
                }
                this.isValidate = true
                this.$socket.emit('message', { unique_id: this.unique_id, msg: this.msg })
                this.msg = ''
            },

            notice() {
                this.hasMsg.isTwinkling = true
                this.video.first = true
                this.video.play = this._.uniqueId(new Date().getTime())
            },

            expand() {
                this.hasMsg.isExpanding = !this.hasMsg.isExpanding
                this.hasMsg.isTwinkling = false
            }
        },

        directives: {
            enter: {
                inserted(el) {
                    el.addEventListener('mouseenter', (e) => e.target.style.overflow = 'auto')

                    el.addEventListener('mouseleave', (e) => e.target.style.overflow = 'hidden')

                    let old = el.scrollHeight
                    el.scrollTop = el.scrollHeight
                    setInterval(() => {
                        if (el.scrollHeight > old) {
                            old = el.scrollHeight
                            el.scrollTop = el.scrollHeight
                        }
                    }, 500)
                }
            },

            hidden: {
                inserted(el) {
                    el.addEventListener('click', () => {
                        let container = el.parentNode.parentNode
                        let bottom = container.style.bottom

                        if (bottom == '') {
                            bottom = '-500px'
                        }
                        if (bottom == '1px') {
                            el.childNodes[1].innerText = 'expand_less'
                            container.style.bottom = '-500px'
                        } else {
                            el.childNodes[1].innerText = 'expand_more'
                            container.style.bottom = '1px'
                        }
                    })
                }
            }
        },

        sockets: {
            message(messagesObj) {
                if (messagesObj.unique_id != this.unique_id) {
                    this.notice()
                }
                this.messages.push(messagesObj)
            }
        },

        mounted() {
//            console.log('unique_id_key: ' + this.unique_id_key)
//            console.log('unique_id: ' + this.getItem(this.unique_id_key))
            this.unique_id = this.getItem(this.unique_id_key)
        }
    }
</script>
