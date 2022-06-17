<template>
  <div class="settings">
    <h1>This is an settings page</h1>

    <div v-if="errormessage">
      {{errormessage}}
    </div>
    <div>
      <label for="numrows">Number of Rows</label>
      <input type="number" v-model="settings.numrows" name="numrows" min="1" max="5">

      <br />
    <!-- {{settings.humandate}} -->
      <label for="humandate">Human date</label>
      <input type="checkbox" v-model="settings.humandate" name="humandate">

      <br />

      <label for="numrows">Emails </label>
      <div class="border" v-for="email, i in settings.emails" :key="i" >
        <input v-model="settings.emails[i]" placeholder="Email">
        <input type="button" value="X" @click="deleteEmail(email)">
      </div>
      <button v-if="settings.emails.length < 10000000000000000000000000000" @click="AddEmail">
        Add New
      </button>
      <br />
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        errormessage: []
      }
    },
    computed: {
      settings() {
        return this.$store.state.Settings;
      }
    },
    methods: {
      AddEmail: function () {
        if(this.settings.emails.length < 5){
          this.$store.commit('AddNewEmail', '' );
        } else {
          this.errormessage = "Only 5 Emails allowed";
        }
      },
      deleteEmail: function(email){
        this.$store.commit('RemoveNewEmail', email );
      }
    }
  };
</script>