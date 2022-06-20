<template>
  <div class="settings">
    <h1 class="sec-title">This is an settings page</h1>

    <div class="fields-wrapper">


      <div class="field-wrapper" v-if="errormessage">
        <div class="alert-error">
        {{ errormessage }}
        </div>
      </div>

      <div class="field-wrapper">
        <div class="label">
          <label for="numrows">Number of Rows</label>
        </div>
        <div class="field">
          <input
            type="number"
            v-model="numrows"
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
            v-model="humandate"
          />
        </div>
      </div>

      <div class="field-wrapper no-border">
        <div class="label">
          <label for="email-0">Emails </label>
        </div>
        <div class="field">
          <div class="emails-list border" v-for="(email, i) in emails" :key="i">
            <input v-on:change="updateEmail(email)" placeholder="Email" :id="'email-' + i" />
            <button @click="deleteEmail(email)" title="Remove">X</button>
          </div>
        </div>
        <button
          class="button button-primary mt-0"
          @click="AddEmail"
          title="Add New"
        >
          +
        </button>
      </div>
      <pre>
        {{$store.state.Settings}}
      </pre>

      <pre>
        {{emails}}
      </pre>
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
    aaaSettings() {
      return this.$store.getters.Settings
    },
    settings() {
      return this.$store.state.Settings;
    },
    numrows: {
      get() {
        return this.settings.numrows
      },
      set(val) {
        if( typeof val === 'number' ) {
          if(val <= 5 && val >= 1){
            this.SaveSetting('numrows', val);
          } else {
            this.errormessage = "Number of Rows should between 1-5.";
          }
        } else {
          this.errormessage = "Number of Rows field should be number only.";
        }
        
      }
    },
    humandate: {
      get() {
        return this.settings.humandate
      },
      set(val) {
        if( typeof val === 'boolean' ) {
          this.SaveSetting('humandate', val);
        } else {
          this.errormessage = "Human Date Only Accept Boolean(true, false) value.";
        }
      }
    },
    emails: {
      get() {
        const emails = JSON.parse(JSON.stringify(this.settings.emails));
        return emails;
      },
      set(val) {
        
        console.log(val)
        console.log("val")
        
      }
    }
  },
  methods: {
    async SaveSetting(name, value){
      const headers = { "X-WP-Nonce": window.wabvap_vue.nonce };
      var data = new FormData();
      data.append( "value", JSON.stringify( value ) );
      
      let response = await fetch(window.wabvap_vue.endpoints.setting_url + "/" + name,
      {
          method: "POST",
          headers,
          body: data
      });
      var body = await response.json();
      console.log(body);

      if(response.status === 200){
        if(body.success == true){
          this.$store.commit("UpdateSingleSetting", {name, value});
          this.errormessage = "";
        } else {
          this.errormessage = body.message;
          // console.log(body.);
        }
        
        
      } else {
        this.errormessage = "Internal Server Error.";
      }

    },
    updateEmail: function(email) {
      console.log(email)
    },
    AddEmail: function () {
      console.log(this.emails);
      console.log(this.emails.length);
      console.log('this.emails.length');
      if (this.emails.length < 5) {
        this.emails.push("");
        console.log(this.emails)
        // this.$store.commit("AddNewEmail", "");
      } else {
        this.errormessage = "Only 5 Emails allowed";
      }
    },
    // deleteEmail: function (email) {
    //   this.$store.commit("RemoveNewEmail", email);
    //   if (this.settings.emails.length < 5) {
    //     this.errormessage = "";
    //   }
    // },
  },
};
</script>
