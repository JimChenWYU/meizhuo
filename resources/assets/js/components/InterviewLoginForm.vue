<template>
  <div>
    <section class="space">
      <navbar class="md-accent" title="面试官认证"></navbar>
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
              <md-button class="md-raised md-accent" type="submit">登录</md-button>
            </md-layout>

          </md-layout>
          <md-layout></md-layout>
        </md-layout>
      </form>
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
        department: '',
        number: '',

        isCanSubmit: true,
        alert: {
          content: '出错了！',
          ok: '确定'
        },
        confirm: {
          title: '确认框',
          contentHtml: `<h3>您确认提交信息吗？</h3>`,
          ok: '确定',
          cancel: '取消'
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
        this.isCanSubmit = false;
        this.$http.post(this.$url.apply, this.userData)
            .then(response => {
              this.isCanSubmit = true;
              this.openDialog('tip', () => {
                this.alert = {
                  content: `${this.userData.department} 报名成功！`,
                  ok: '确定'
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
  }
</script>