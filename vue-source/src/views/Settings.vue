<template>
  <div class="settings-content">
    <h2 class="sec-title">This is an settings page</h2>

    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row">
            <label for="numrows">Number of Rows</label>
          </th>
          <td>
            <input
              type="number"
              v-model="settings.numrows"
              name="numrows"
              id="numrows"
              min="1"
              max="5"
            />
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label for="numrows">Number of Rows</label>
          </th>
          <td>
            <input
              type="number"
              v-model="settings.numrows"
              name="numrows"
              id="numrows"
              min="1"
              max="5"
            />
          </td>
        </tr>
      </tbody>
    </table>

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
        <!-- alert -->
        <div v-if="errormessage" class="notice notice-error is-dismissible">
          <p>{{ errormessage }}</p>
          <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
          </button>
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
