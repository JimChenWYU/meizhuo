<template>
  <div>
    <section class="space">
      <navbar class="md-accent" title="面试官认证" style="text-align: center"></navbar>
    </section>

    <section>
      <form role="form" novalidate @submit.stop.prevent="openDialog('confirmSubmit')">
        <md-layout md-gutter>
          <md-layout></md-layout>
          <md-layout md-flex="40">
            <md-input-container :class="{ 'md-input-invalid' : errors.department }">
              <label for="department">部门</label>
              <md-select name="department"
                         id="department"
                         v-model="department"
                         required>
                <md-option value="移动组">安卓组</md-option>
                <md-option value="Web组">Web组</md-option>
                <md-option value="美工组">美工组</md-option>
                <md-option value="营销策划">营销策划</md-option>
              </md-select>
              <span class="md-error"
                    v-for="(error, index) of errors.department"
                    v-if="index === 0">{{error}}</span>
            </md-input-container>

            <md-input-container :class="{ 'md-input-invalid' : errors.number }">
              <label for="number">组数</label>
              <md-select name="number"
                         id="number"
                         v-model="number"
                         required>
                <md-option value="1">1</md-option>
                <md-option value="2">2</md-option>
                <md-option value="3">3</md-option>
              </md-select>
              <span class="md-error"
                    v-for="(error, index) of errors.number"
                    v-if="index === 0">{{error}}</span>
            </md-input-container>

            <br/>
            <md-layout md-column>
              <md-button :disabled="!isCanSubmit" class="md-raised md-accent" type="submit">登录</md-button>
            </md-layout>

          </md-layout>
          <md-layout></md-layout>
        </md-layout>
      </form>

      <!-- 确认弹框 -->
      <md-dialog-confirm
              :md-content-html="confirm.contentHtml"
              :md-ok-text="confirm.ok"
              :md-cancel-text="confirm.cancel"
              @open="onOpen"
              @close="onConfirmClose"
              ref="confirmSubmit">
      </md-dialog-confirm>

      <!-- 提示弹框 -->
      <md-dialog-alert
              :md-content="alert.content"
              :md-ok-text="alert.ok"
              @open="onOpen"
              @close="onClose"
              ref="tip">
      </md-dialog-alert>

      <md-snackbar md-position="top center" ref="snackbar" md-duration="4000">
        <span>{{ error.msg }}</span>
      </md-snackbar>
    </section>
  </div>
</template>
<style scoped>
  .space {
    margin-bottom: 70px;
  }
</style>
<script type="es6">
    import Navbar from './layouts/Navbar.vue'
    export default {
        components: {
            Navbar
        },

        replace: false,

        data() {
            return {
                unique_id_key: '',
                unique_id: '',
                department: '',
                number: '',

                isCanSubmit: true,
                alert: {
                    content: '出错了！',
                    ok: '确定'
                },
                confirm: {
                    contentHtml: '<h3>您确认提交信息吗？</h3>',
                    ok: '确定',
                    cancel: '取消'
                },
                error: {
                    msg: '出错了！'
                }
            }
        },

        vuerify: {
            number: [
                'required',
                {test: /[1|2|3]/, message: '只能是1, 2, 3'}
            ],
            department: ['required']
        },

        computed: {
            groupData () {
                return {
                    unique_id: this.unique_id,
                    number: this.number,
                    department: this.department,
                }
            },

            errors () {
                return this.$vuerify.$errors
            },

            validate() {
                return this.$vuerify.check()
            }
        },

        methods: {
            submit() {
                this.isCanSubmit = false
                this.$http.post(this.$url.interview, this.groupData)
                    .then(response => {
//                        console.log(response)
                        this.isCanSubmit = true;
                        if(response.data.error) {
                            this.error.msg = response.data.error.message
                            this.$refs.snackbar.open();
                            return false
                        }
                        this.$router.push({ name: 'interview.home', params: this.groupData })
                        return false
                    })
                    .catch(error => {
                      this.isCanSubmit = true;
                      this.openDialog('tip', () => {
                        this.alert = {
                          content: error.data.error.message,
                          ok: '确定'
                        }
                      })
                    })
            },

            onOpen() {
            },

            onClose(type) {
              console.log('Closed', type)
            },

            onConfirmClose(type) {
              if (type === 'ok') {
                this.submit()
              }
            },

            // 处理弹框
            openDialog(ref, callback) {
              if (this._.isFunction(callback)) {
                callback();
              }
              switch(ref) {
                case 'confirmSubmit':
                  if (! this.validate) {
                    break;
                  }
                case 'tip':
                  this.$refs[ref].open();
                  break;
              }

            },

            closeDialog(ref) {
              this.$refs[ref].close();
            }
        },

        sockets: {
            connect() {
                console.log(`管理员登陆-socket_id: ${this.$socket.id}`)
                this.unique_id = this.$socket.id
                this.isCanSubmit = true
                console.log(this.groupData)
            }
        },

        created() {
            this.$socket.connect()
            console.log(this.$socket.connect())
        }
    }
</script>