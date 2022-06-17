import { createStore } from "vuex";

export default createStore({
  state: {
    WabvapVue: {},
    Data: {},
    Settings: {
      numrows: 5,
      humandate: true,
      emails: {},
    },
  },
  mutations: {
    UpdateWabvapVue(state, data) {
        state.WabvapVue = data;
    },
    UpdateData(state, data) {
        state.Data = data;
    },
    UpdateSettings(state, data) {
        state.Settings = {
          numrows: data.numrows,
          humandate: data.humandate,
          emails: data.emails,
        };
    },
    AddNewEmail(stete, email){
      stete.Settings.emails.push(email);
    },
    RemoveNewEmail(stete, email){
      const i = stete.Settings.emails.findIndex(function(item){return item == email;});
      stete.Settings.emails.splice(i, 1);
    },
  }
});