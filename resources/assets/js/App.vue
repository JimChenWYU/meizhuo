<template>
    <div id="app">
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
<style>
    .h1, .h2, .h3, h1, h2, h3 {
        margin-top: 20px;
        margin-bottom: 10px;
    }
</style>
<script type="es6">
    import Navbar from './components/layouts/Navbar'
    export default{
        name: 'app',
        replace: false
    }
</script>
