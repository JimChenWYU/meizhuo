<template>
  <div>
    <section>
      <navbar class="md-transparent"></navbar>
    </section>

    <section>
      <form novalidate @submit.stop.prevent="openDialog('confirmSubmit')">
        <md-layout md-gutter>
          <md-layout></md-layout>
          <md-layout md-flex="60">
            <div class="field-group">
              <md-input-container :class="{ 'md-input-invalid' : errors.name }">
                <label>姓名</label>
                <md-input type="text"
                          v-model="name"
                          required></md-input>
                <span class="md-error"
                      v-for="(error, index) of errors.name"
                      v-if="index === 0">{{error}}</span>
              </md-input-container>

              <md-input-container :class="{ 'md-input-invalid' : errors.student_id }">
                <label>学号</label>
                <md-input type="text"
                          v-model.number="student_id"
                          required></md-input>
                <span class="md-error"
                      v-for="(error, index) of errors.student_id"
                      v-if="index === 0">{{error}}</span>
              </md-input-container>

              <md-input-container :class="{ 'md-input-invalid' : errors.department }">
                <label for="department">意向部门</label>
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

            </div>

            <md-dialog-confirm
                    :md-title="confirm.title"
                    :md-content-html="confirm.contentHtml"
                    :md-ok-text="confirm.ok"
                    :md-cancel-text="confirm.cancel"
                    @open="onOpen"
                    @close="onConfirmClose"
                    ref="confirmSubmit">
            </md-dialog-confirm>

            <!-- 弹框 -->
            <md-dialog-alert
                    :md-content-html="alert.content"
                    :md-ok-text="alert.ok"
                    @open="onOpen"
                    @close="onClose"
                    ref="tip">
            </md-dialog-alert>

          </md-layout>
          <md-layout>
          </md-layout>
        </md-layout>

        <md-layout md-gutter>
          <md-layout></md-layout>
          <md-layout md-flex="80">
            <md-button class="md-raised md-primary" type="submit" md-fab-bottom-center :disabled="!isCanSubmit">签到</md-button>
            <md-button class="md-raised md-warn" type="button" md-fab-bottom-center :disabled="!isCanUpdate" @click.native="update()">刷新</md-button>
          </md-layout>
        </md-layout>
      </form>
    </section>

    <section class="clear"></section>

    <section class="department">
      <md-layout md-gutter>
        <md-layout md-flex-xsmall="100" md-flex-small="50" md-flex-medium="33">
          <md-card class="group">
            <h2>安卓组</h2>
            <p v-for="android of lineUp.android" class="container-group">
              <md-layout>
                <md-layout>
                  <span class="space">{{ android.student_id }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">{{ android.name }}</span>
                </md-layout>

                <md-layout>
                  <span class="space" :class="[statusColor(android.status)]">{{ statusTip(android.status) }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">
                    <md-button class="md-icon-button" @click.native="delSigner(android.id)">
                        <md-icon>delete</md-icon>
                      </md-button>
                  </span>
                </md-layout>
              </md-layout>
            </p>
          </md-card>
        </md-layout>

        <div class="space"></div>

        <md-layout md-flex-xsmall="100" md-flex-small="50" md-flex-medium="33">
          <md-card class="group">
            <h2>Web组</h2>
            <p v-for="web of lineUp.web" class="container-group">
              <md-layout>
                <md-layout>
                  <span class="space">{{ web.student_id }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">{{ web.name }}</span>
                </md-layout>

                <md-layout>
                  <span class="space" :class="[statusColor(web.status)]">{{ statusTip(web.status) }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">
                    <md-button class="md-icon-button" @click.native="delSigner(web.id)">
                        <md-icon>delete</md-icon>
                      </md-button>
                  </span>
                </md-layout>
              </md-layout>
            </p>
          </md-card>
        </md-layout>

        <div class="space"></div>

        <md-layout md-flex-xsmall="100" md-flex-small="50" md-flex-medium="33">
          <md-card class="group">
            <h2>美工组</h2>
            <p v-for="design of lineUp.design" class="container-group">
              <md-layout>
                <md-layout>
                  <span class="space">{{ design.student_id }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">{{ design.name }}</span>
                </md-layout>

                <md-layout>
                  <span class="space" :class="[statusColor(design.status)]">{{ statusTip(design.status) }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">
                    <md-button class="md-icon-button" @click.native="delSigner(design.id)">
                        <md-icon>delete</md-icon>
                      </md-button>
                  </span>
                </md-layout>
              </md-layout>
            </p>
          </md-card>
        </md-layout>

        <div class="space"></div>

        <md-layout md-flex-xsmall="100" md-flex-small="50" md-flex-medium="33">
          <md-card class="group">
            <h2>营销策划</h2>
            <p v-for="marking of lineUp.marking" class="container-group">
              <md-layout>
                <md-layout>
                  <span class="space">{{ marking.student_id }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">{{ marking.name }}</span>
                </md-layout>

                <md-layout>
                  <span class="space" :class="[statusColor(marking.status)]">{{ statusTip(marking.status) }}</span>
                </md-layout>

                <md-layout>
                  <span class="space">
                    <md-button class="md-icon-button" @click.native="delSigner(marking.id)">
                        <md-icon>delete</md-icon>
                      </md-button>
                  </span>
                </md-layout>
              </md-layout>
            </p>
          </md-card>
        </md-layout>
      </md-layout>
    </section>

  </div>
</template>
<style scoped>
  p {
    margin: 0;
  }

  .container-group {
    width: 100%;
    min-height: 48px;
    margin: 4px 0 24px;
    padding-top: 16px;
    display: -ms-flexbox;
    display: flex;
    position: relative;
  }

  .container-group::after {
    height: 1px;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,.12);
    content: " ";
    position: absolute;
    left: 0;
    transition: all .4s cubic-bezier(.25,.8,.25,1);
  }

  .field-group {
    width: 100%;
    display: flex;
  }
  .clear {
    height: 60px;
    display: block;
  }

  .group {
    width: 100%;
    text-align: center;
    padding: 0 10px 0px 10px;
  }

  .group h2 {
    padding-bottom: 10px;
  }

  .space {
    padding: 0 5px 0 5px;
    height: 40px;
    display:inline-block;
    line-height: 40px;
  }

  .department {
    padding: 0 40px 0 40px;
  }

  .blue {
    color: #2196F3;
  }

  .green {
    color: #228b22;
  }
  
  .red {
    color: #ff1411;
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
                  name: '',
                  student_id: '',
                  department: '',

                  isCanSubmit: true,
                  isCanUpdate: true,

                  alert: {
                      content: '出错了！',
                      ok: '确定'
                  },

                  confirm: {
                      title: '确认框',
                      contentHtml: `<h3>您确认提交信息吗？</h3>`,
                      ok: '确定',
                      cancel: '取消'
                  },

                  lineUp: {
                      android: [
            //            { student_id: '3114002521', name: '123', status: '3' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
                      ],
                      web: [
            //            { student_id: '3114002521', name: '123', status: '2' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
                      ],
                      design: [
            //            { student_id: '3114002521', name: '123', status: '3' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
                      ],
                      marking: [
            //            { student_id: '3114002521', name: '123', status: '3' },
            //            { student_id: '3114002526', name: '123', status: '2' },
            //            { student_id: '3114002526', name: '123', status: '1' },
            //            { student_id: '3114002526', name: '123', status: '1' },
                      ],
                  }
              }
          },

          vuerify: {
              name: [ 'required' ],
              student_id: [
                  'required', {test: /^[0-9]{10,10}$/, message: '只能是10位数字'}
              ],
              department: [ 'required' ]
          },

          computed: {
              userData () {
                  return {
                      name: this.name,
                      student_id: this.student_id,
                      department: this.department
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
                  this.isCanSubmit = false;
                  this.$http.post(this.$url.sign, this.userData)
                      .then(response => {
                          this.isCanSubmit = true;
                          this.openDialog('tip', () => {
                              if (this._.isUndefined(response.data.error)) {
                                  this.lineUp = response.data
                                  this.alert = {
                                      content: `${this.userData.department} 签到成功！`,
                                      ok: '确定'
                                  }
                              } else {
                                  this.alert = {
                                      content: `${this.userData.name} <strong style="color: #ff1411">签到失败</strong>`,
                                      ok: '确定'
                                  }
                              }
                        })
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

              statusColor(status) {
                  switch (status * 1) {
                      case 1:
                          return 'blue';
                      case 2:
                          return 'green';
                      case 3:
                          return 'red';
                      default:
                          return 'black';
                  }
              },

              statusTip(status) {
                  switch (status * 1) {
                      case 1:
                          return '排队中';
                      case 2:
                          return '就绪中';
                      case 3:
                          return '面试中';
                      default:
                          return '未知';
                  }
              },

              update() {
                  this.isCanUpdate = false
                  this.$http.get(this.$url.signers)
                      .then(response => {
                          this.lineUp = response.data
                          this.isCanUpdate = true
                      })
                      .catch(error => {
                          this.isCanUpdate = true
                      })
              },

              delSigner(id) {
                  if(id) {
                      if (confirm('确定要从此队列中删除他 (她) 吗？')) {
                          this.$http.delete(this.$url.delSigner, {
                              params: {
                                  id: id
                              },
                          }).then(response => {
                              this.lineUp = response.data
                          }).catch(error => {})
                      }
                  }
              },

              onOpen() {
                // console.log(this.userData);
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

          mounted() {
              this.update()
          },

          sockets: {
              updateSignerListChannel(dataList) {
                  this.lineUp = dataList
              }
          }
    }
</script>