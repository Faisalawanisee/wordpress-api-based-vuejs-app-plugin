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
    // updateCartItem(state, updatedItem) {
    //   state.cart = state.cart.map((cartItem) => {
    //     if (cartItem.id == updatedItem.id) {
    //       return updatedItem;
    //     }

    //     return cartItem;
    //   });
    // },
  }
});