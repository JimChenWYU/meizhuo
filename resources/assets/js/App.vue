<template>
    <div id="app">
        <section class="header">
            <navbar :title="title"></navbar>
        </section>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                <!-- route outlet -->
                <router-view></router-view>
            </section>
            <!-- /.content -->
		  	<!--<router-link :to="{ name: 'sign', params: { userId: 123 }}">Sign</router-link>-->
		</div>
    </div>
</template>
<script type="es6">
    import Navbar from './components/layouts/Navbar'
    export default{
        name: 'app',
        data() {
            return{
              title:'袂卓工作室招新报名'
            }
        },
        components: {
            Navbar
        },
        replace: false
    }
</script>
