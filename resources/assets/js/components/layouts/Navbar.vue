<template>
    <md-toolbar class="md-dense header-tab">
        <h2 class="md-title" style="flex: 1">{{title}}</h2>
    </md-toolbar>
</template>
<style scoped>
    .header-tab {
        margin-bottom: 20px;
    }
</style>
<script type="es6">
    export default{
        props: {
            title: {
                type: String,
                default: ''
            },
        }
    }
</script>
