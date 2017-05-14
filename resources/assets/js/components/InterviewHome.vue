<template>
  <div>
    <section class="space">
      <navbar class="md-accent" title="欢迎面试官"></navbar>
    </section>

    <section class="padding-left-right-30px">
      <form class="field-group" novalidate @submit.stop.prevent="search()">
          <md-input-container :class="{ 'md-input-invalid' : errors.search_student_id }">
            <label>学号</label>
            <md-input type="text"
                      v-model.number="search_student_id"
                      required></md-input>
            <span class="md-error"
                  v-for="(error, index) of errors.search_student_id"
                  v-if="index === 0">{{error}}</span>
          </md-input-container>

          <md-input-container :class="{ 'md-input-invalid' : errors.search_department }">
            <label>意向部门</label>
            <md-select v-model="search_department"
                       required>
              <md-option value="移动组">安卓组</md-option>
              <md-option value="Web组">Web组</md-option>
              <md-option value="美工组">美工组</md-option>
              <md-option value="营销策划">营销策划</md-option>
            </md-select>
            <span class="md-error"
                  v-for="(error, index) of errors.search_department"
                  v-if="index === 0">{{error}}</span>

            <md-button class="md-icon-button" type="submit">
              <md-icon>search</md-icon>
            </md-button>
          </md-input-container>
      </form>
    </section>

    <section class="padding-left-right-30px">
      <md-table-card class="main-content">
        <md-table>
          <md-table-header>
            <md-table-row>
              <md-table-head>学号</md-table-head>
              <md-table-head>姓名</md-table-head>
              <md-table-head>专业</md-table-head>
              <md-table-head>联系方式</md-table-head>
              <md-table-head>年级</md-table-head>
              <md-table-head>意向部门</md-table-head>
            </md-table-row>
          </md-table-header>

          <md-table-body>
            <md-table-row>
              <md-table-cell>{{ person['student_id'] }}</md-table-cell>
              <md-table-cell>{{ person['name'] }}</md-table-cell>
              <md-table-cell>{{ person['major'] }}</md-table-cell>
              <md-table-cell>{{ person['phone_num'] }}</md-table-cell>
              <md-table-cell>{{ person['grade'] }}</md-table-cell>
              <md-table-cell>{{ person['department'] }}</md-table-cell>
            </md-table-row>
            <md-table-row>
              <md-table-head>是否网上报名</md-table-head>
              <md-table-head>状态</md-table-head>
              <md-table-head colspan="4" style="text-align: center">简介</md-table-head>
            </md-table-row>
            <md-table-row>
              <md-table-cell>{{ tranHasApply(person['has_apply']) }}</md-table-cell>
              <md-table-cell>{{ tranStatus(person['status']) }}</md-table-cell>
              <md-table-cell colspan="4">{{ person['introduce'] }}</md-table-cell>
            </md-table-row>
          </md-table-body>
        </md-table>
      </md-table-card>
    </section>

    <section class="padding-left-right-30px padding-top-30px">
        <md-layout>
            <md-layout md-column>
              <md-button :disabled="!isCanLogout"
                      class="md-raised md-warn" @click.native="logout()">退出</md-button></md-layout>
          <md-layout md-column>
              <md-button :disabled="!isCanLogout"
                      class="md-raised md-accent" @click.native="openDialog('confirmNext')">{{ buttonTip }}</md-button></md-layout>
        </md-layout>
    </section>

    <section><IM :unique_id_key="unique_id_key"></IM></section>

    <md-snackbar md-position="top center" ref="not_search" md-duration="4000">
      <span>搜索不到！</span>
      <md-button class="md-accent" md-theme="light-blue" @click.native="search()">Retry</md-button>
    </md-snackbar>

    <md-snackbar md-position="top center" ref="error" md-duration="4000">
      <span>{{ error }}</span>
    </md-snackbar>

    <md-dialog-alert
            :md-content="alert.content"
            :md-ok-text="alert.ok"
            @close="onClose"
            ref="alert">
    </md-dialog-alert>

    <md-dialog-confirm
          md-content-html="<h3>您确认到下一个面试者吗？</h3>"
          md-ok-text="确定"
          md-cancel-text="取消"
          @close="onConfirmClose"
          ref="confirmNext">
    </md-dialog-confirm>
  </div>
</template>
<style scoped>
  .space {
    margin-bottom: 70px;
  }

  .padding-left-right-30px {
    padding: 0 30px 0 30px;
  }

  .padding-top-30px {
    padding-top: 30px;
  }

  .field-group {
    width: 100%;
    display: flex;
  }
</style>
<script type="es6">
    import Navbar from './layouts/Navbar.vue'
    import IM from './layouts/IMDialogue.vue'
    export default {
        components: {
            Navbar, IM
        },

        replace: false,

        data() {
            return {

                search_student_id: '',
                search_department: '',

                unique_id_key: '',

                error: '',
                isCanLogout: true,

                alert: {
                    ok: '确定',
                    content: ''
                },

                person: {
                    id: '',
                    name: '',
                    student_id: '',
                    major: '',
                    phone_num: '',
                    grade: '',
                    department: '',
                    introduce: '',

                    has_apply: '',
                    status: ''
                }
            }
        },

        vuerify: {
            search_student_id: [
                'required',
                {test: /^[0-9]{10,10}$/, message: '只能是10位数字'}
            ],
            search_department: ['required']
        },

        computed: {
            searchData () {
                return {
                    student_id: this.search_student_id,
                    department: this.search_department
                }
            },

            errors () {
                return this.$vuerify.$errors
            },

            validate() {
                return this.$vuerify.check()
            },

            buttonTip() {
                return `下一个面试者`
            }
        },

        methods: {
            tranStatus(status) {
                switch (status * 1) {
                    case 1:
                        return '排队中'
                    case 2:
                        return '就绪中'
                    case 3:
                        return '面试中'
                    case 4:
                        return '已结束面试'
                    default:
                        return '未知'
                }
            },

            tranHasApply(status) {
//                console.log(this._.isBoolean(status))
//                console.log(this._.isUndefined(status))
//                console.log(this._.isEmpty(status))
                if (!this._.isBoolean(status) &&
                    (this._.isUndefined(status) || this._.isEmpty(status))) {
                    return '未知'
                }

                if (status) {
                    return '网上报名'
                }

                return '线下报名'
            },

            logout() {
                this.isCanLogout = false
                this.$http.get(this.$url.interviewOut)
                    .then(response => {
                        if (response.data.error) {
                            this.error = response.data.error.message
                            this.openDialog('error')
                            this.isCanLogout = true
                            return;
                        }
                        this.isCanLogout = true
//                        window.location.reload()
                        this.$router.push({ name: 'interview.login' })
                    })
                    .catch(error => {
                        if (error.data.error) {
                            this.error = error.data.error.message
                            this.openDialog('error')
                        }
                        window.location.reload()
                    })
            },

            begin() {
                this.isCanLogout = false
                this.$http.get(this.$url.interviewBegin, {
                    params: {
                        current_signer_id: this.person.id
                    }
                }).then(response => {
                    this.isCanLogout = true
                    if (response.data.error) {
                        this.error = response.data.error.message
                        this.openDialog('error')
                        return
                    }

                    this.person = response.data
                }).catch(error => {
                    this.isCanLogout = true
                    if (error.data.error) {
                        this.error = error.data.error.message
                        this.openDialog('error')
                        return
                    }
                })
            },

            search() {
                if (! this.validate) return false
                this.$http.post(this.$url.interviewSearch, this.searchData)
                    .then(response => {
                        this.person = response.data
                    })
                    .catch(errors => {
                        if (errors.data.errors) {
                            this.openDialog('not_search')
                        }
                    })
            },

            openDialog(tag, callback) {
                if (this._.isFunction(callback)) {
                    callback();
                }
                this.$refs[tag].open();
            },

            onConfirmClose(type) {
                if (type === 'ok') {
                    this.begin()
                }
            },

            onClose(type) {
//                console.log(type)
                this.$router.push({ name: 'interview.login' })
            },

            validateAuth() {
                let auth = this.$route.params
                if (this._.isUndefined(auth) || !auth.unique_id_key) {
                    this.$socket.emit('interviewLogout');
                    this.$router.push({ name: 'interview.login'})
                }
//                console.log(`home: ${auth.unique_id_key}`)
//                console.log(`home: ${this.getItem(auth.unique_id_key)}`)
                this.unique_id_key = auth.unique_id_key
            },
        },

        sockets: {
            logout(interviewer) {
//                console.log(interviewer)
                if (this.getItem(this.unique_id_key) == interviewer.unique_id) {
                    this.openDialog('alert', () => {
                        this.alert = {
                            ok: '确定',
                            content: '您被管理员强制退出，如有疑问请联系管理员'
                        }
                    })
                }
            }
        },

        created() {
            this.validateAuth()
        }
    }
</script>