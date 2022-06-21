import { createStore } from "vuex";

export default createStore({
  state: {
    Data: {},
    Settings: {
      numrows: 0,
      humandate: false,
      emails: [],
    },
  },
  mutations: {
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
    UpdateSingleSetting(state, data) {
        state.Settings[data.name] = data.value
    },
  }
});