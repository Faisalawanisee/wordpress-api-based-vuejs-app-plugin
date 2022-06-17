<template>
  <div class="settings">
    <h1>This is an settings page</h1>

    <div>
      <label for="numrows">Number of Rows</label>
      <input type="number" v-model="settings.numrows" name="numrows" min="1" max="5">

      <br />
    <!-- {{settings.humandate}} -->
      <label for="humandate">Human date</label>
      <input type="checkbox" v-model="settings.humandate" name="humandate">

      <br />

      <label for="numrows">Number of Rows</label>
      <input v-model="settings.numrows" name="numrows" min="1" max="5">

      <br />
      
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
      }
    },
    computed: {
      settings() {
        return this.$store.state.Settings;
      }
    },
  };
</script>