<template>
    <nav class="header-tab">
        <md-toolbar class="md-dense">
            <h2 class="md-title" style="flex: 1">{{title}}</h2>
        </md-toolbar>
    </nav>
</template>
<script type="es6">
    export default{
        props: {
            title: {
                type: String,
                default: 'default title'
            },
        }
    }
</script>
