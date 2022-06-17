<template>
  <div class="settings">
    <h1 class="sec-title">This is an settings page</h1>

    <div class="fields-wrapper">
      <div class="field-wrapper">
        <div class="label">
          <label for="numrows">Number of Rows</label>
        </div>
        <div class="field">
          <input
            type="number"
            v-model="settings.numrows"
            name="numrows"
            id="numrows"
            min="1"
            max="5"
          />
        </div>
      </div>

      <div class="field-wrapper">
        <div class="label">
          <label for="humandate">Human date</label>
        </div>
        <div class="field">
          <input
            type="checkbox"
            name="humandate"
            id="humandate"
            v-model="settings.humandate"
          />
        </div>
      </div>

      <div class="field-wrapper no-border">
        <div class="alert-error" v-if="errormessage">
          {{ errormessage }}
        </div>

        <div class="label">
          <label for="email-0">Emails </label>
        </div>
        <div class="field">
          <div class="emails-list border" v-for="(email, i) in settings.emails" :key="i">
            <input v-model="settings.emails[i]" placeholder="Email" :id="'email-' + i" />
            <button @click="deleteEmail(email)">X</button>
          </div>
        </div>
      </div>
      <button
        class="button button-primary mt-0"
        v-if="settings.emails.length < 10000000000000000000000000000"
        @click="AddEmail"
      >
        Add New
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errormessage: "",
    };
  },
  computed: {
    settings() {
      return this.$store.state.Settings;
    },
  },
  methods: {
    AddEmail: function () {
      if (this.settings.emails.length < 5) {
        this.$store.commit("AddNewEmail", "");
      } else {
        this.errormessage = "Only 5 Emails allowed";
      }
    },
    deleteEmail: function (email) {
      this.$store.commit("RemoveNewEmail", email);
      if (this.settings.emails.length < 5) {
        this.errormessage = "";
      }
    },
  },
};
</script>
