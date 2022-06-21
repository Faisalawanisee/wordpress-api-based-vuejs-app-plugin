<template>
  <div v-if="settings" class="settings-content">
    <h2 class="sec-title">{{i18n('page_title_settings')}}</h2>
    
    <div v-if="errormessage" class="notice notice-error">
      <p>{{ errormessage }}</p>
    </div>
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row">
            <label for="numrows">{{i18n('num_of_rows')}}</label>
          </th>
          <td>
            <input
              type="number"
              v-model="numrows"
              name="numrows"
              id="numrows"
              min="1"
              max="5"
            />
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label for="humandate">{{i18n('human_date')}}</label>
          </th>
          <td>
            <input type="checkbox" name="humandate" id="humandate" v-model="humandate" />
          </td>
        </tr>
        <tr>
          <th scope="row" class="v-align-top">
            <label for="email-0">{{i18n('emails')}}</label>
          </th>
          <td>
            <div v-if="emails" :class="'email-wrapper-'+trigger">
              <div v-for="(email, i) in emails" :key="i">
                <div class="mt-5 d-flex">
                  <input
                    v-on:keyup="updateEmail(email)"
                    v-model="emails[i].email"
                    placeholder="Email"
                    :id="'email-' + i"
                    type="email"
                  />
                  <button @click="deleteEmail(email)" class="button my-0 del-btn">X</button>
                </div>
                <div v-if="!email.valid">
                  <small style="color:red">{{i18n('add_valid_email_address')}}</small>
                </div>
              </div>
              <div>
                <button class="button button-primary mt-5" @click="addEmail">+</button>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errormessage: "",
      trigger: 1,
      emails_temp: []
    };
  },
  computed: {
    settings() {
      return this.$store.state.Settings;
    },
    numrows: {
      get() {
        return this.settings.numrows;
      },
      set(val) {
        if (typeof val === "number") {
          if (val <= 5 && val >= 1) {
            this.SaveSetting("numrows", val);
          } else {
            this.errormessage = "Number of Rows should between 1-5.";
          }
        } else {
          this.errormessage = "Number of Rows field should be number only.";
        }
      },
    },
    humandate: {
      get() {
        return this.settings.humandate;
      },
      set(val) {
        if (typeof val === "boolean") {
          this.SaveSetting("humandate", val);
        } else {
          this.errormessage = this.i18n('human_date_accept_boolean');
        }
      },
    },
    emails(){
      const emails = JSON.parse(JSON.stringify(this.settings.emails));
      let output = [];
      for (let email = 0; email < emails.length; email++) {
        output.push(
          {
            id: this.uuid(),
            email: emails[email],
            valid: true
          }
        );
        
      }
      return output;
    }
  },
  methods: {
    validateEmail(email) {
      var validRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,9}$/;
      if (email.match(validRegex)) return true;
    },
    updateEmail(email_obj) {
      this.trigger += 1;
      if(this.validateEmail(email_obj.email)){
        this.findEmail(email_obj).valid = true
        this.readyEmails();
        this.SaveSetting('emails', this.emails_temp);
      } else {
        this.findEmail(email_obj).valid = false
      }
    },
    findEmail(email_obj){
      return this.emails.find(email => email === email_obj);
    },
    addEmail() {
      this.trigger += 1;
      if (this.emails.length < 5) {
        this.emails.push(
          {
            id: this.uuid(),
            email: "",
            valid: true
          },
        );
      } else {
        this.errormessage = "Only 5 Emails allowed";
      }
    },
    deleteEmail(email_obj) {
      console.log(email_obj);
      const index = this.emails.findIndex(email => email === email_obj);
      console.log(index);
      if (index > -1) {
        this.emails.splice(index, 1);
        this.readyEmails();
        this.SaveSetting('emails', this.emails_temp);
        this.trigger += 1;
      }
      if (this.emails.length < 5) {
        this.errormessage = "";
      }
    },
    readyEmails(){
      this.emails_temp = [];
      for (let email = 0; email < this.emails.length; email++) {
        const email_obj = this.emails[email];
        if(email_obj.valid){
          this.emails_temp.push(email_obj.email)
        }
      }
      this.trigger += 1;
    },
    
    async SaveSetting(name, value) {
      const headers = { "X-WP-Nonce": window.wabvap_vue.nonce };
      var data = new FormData();
      data.append("value", JSON.stringify(value));

      let response = await fetch(window.wabvap_vue.endpoints.setting_url + "/" + name, {
        method: "POST",
        headers,
        body: data,
      });
      var body = await response.json();

      if (response.status === 200) {
        if (body.success == true) {
          this.$store.commit("UpdateSingleSetting", { name, value });
          this.errormessage = "";
        } else {
          this.errormessage = body.message;
        }
      } else {
        this.errormessage = this.i18n('server_error');
      }
    },
  },
};
</script>
