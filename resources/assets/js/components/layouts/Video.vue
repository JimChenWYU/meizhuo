<template>
  <video controls name="media" :class="{ none: !show }" :muted="muted" v-listen:play="play">
    <source src="images/default.mp3" />
  </video>
</template>

<style scoped>
    .none {
        display: none;
    }
</style>

<script type="es6">
  export default {
      props: {
          muted: {
              type: Boolean,
              default: false
          },

          show: {
              type: Boolean,
              default: false
          },

          play: {
              type: [Number, String],
              default: ''
          }
      },

      directives: {
          listen(el, binding) {
              el.load()
              el.play()
          }
      }
  }
</script>