<template>
    <md-layout md-gutter>
        <md-layout md-flex="25" md-hide-xsmall></md-layout>
        <md-layout md-column>
            <form novalidate @submit.stop.prevent="openDialog('confirmSubmit')">
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

                <md-input-container :class="{ 'md-input-invalid' : errors.major }">
                    <label>专业</label>
                    <md-input type="text"
                              v-model="major"
                              required></md-input>
                    <span class="md-error"
                          v-for="(error, index) of errors.major"
                          v-if="index === 0">{{error}}</span>
                </md-input-container>

                <md-input-container :class="{ 'md-input-invalid' : errors.phone_num }">
                    <label>手机号码</label>
                    <md-input type="tel"
                              v-model="phone_num"
                              required></md-input>
                    <span class="md-error"
                          v-for="(error, index) of errors.phone_num"
                          v-if="index === 0">{{error}}</span>
                </md-input-container>

                <md-input-container :class="{ 'md-input-invalid' : errors.grade }">
                    <label for="grade">年级</label>
                    <md-select name="grade"
                               id="grade"
                               v-model="grade"
                               required>
                        <md-option value="大一">大一</md-option>
                        <md-option value="大二">大二</md-option>
                    </md-select>
                    <span class="md-error"
                          v-for="(error, index) of errors.grade"
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

                <md-input-container>
                    <label>简介</label>
                    <md-textarea maxlength="300" v-model="introduce"></md-textarea>
                    <!--<span class="md-error"-->
                    <!--v-for="(error, index) of errors.introduce"-->
                    <!--v-if="index === 0">{{error}}</span>-->
                </md-input-container>

                <md-layout md-column>
                    <md-button class="md-raised md-primary" type="submit" md-fab-bottom-center>确定</md-button>
                </md-layout>


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
                        :md-content="alert.content"
                        :md-ok-text="alert.ok"
                        @open="onOpen"
                        @close="onClose"
                        ref="tip">
                </md-dialog-alert>
            </form>
        </md-layout>
        <md-layout md-flex="25" md-hide-xsmall></md-layout>
    </md-layout>
</template>
<style scoped>
    form {
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
<script type="es6">
    export default {
        data() {
            return {
                name: '陈君武',
                student_id: '3114002521',
                major: '计算机科学与技术',
                phone_num: '18219111672',
                grade: '大一',
                department: '营销策划',
                introduce: '哈哈哈哈哈',

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
            name: ['required'],
            student_id: [
                'required',
                {test: /[0-9]+/, message: '只能是数字'}
            ],
            major: ['required'],
            phone_num: [
                'required',
                {test: /[0-9]+/, message: '只能是数字'}
            ],
            grade: ['required'],
            department: ['required']
        },

        computed: {
            userData () {
                return {
                    name: this.name,
                    student_id: this.student_id,
                    major: this.major,
                    phone_num: this.phone_num,
                    grade: this.grade,
                    department: this.department,
                    introduce: this.introduce
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
//                console.log('submit')
//                console.log(this.$url.sign)
//                console.log(this.userData)
                this.$http.post(this.$url.sign, this.userData)
                        .then(response => {
                          console.log(response)
                            this.openDialog('tip', () => {
                                this.alert = {
                                    content: `${this.userData.department} 报名成功！`,
                                    ok: '确定'
                                }
                            })
                        })
                        .catch(error => {
                            console.log(error)
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
                console.log(type === 'ok')
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
