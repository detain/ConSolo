/*
For a full explanation of how it all works please check:
https://www.ivanreyne.ninja/2019/09/30/vue-js-and-vuetify-quick-prototypes-all-in-one/
*/
new Vue({
  el: "#app",
  vuetify: new Vuetify({
    theme: {
      options: {
        customProperties: true
      },
      themes: {
        light: {
          primary: "#4dd0e1",
          secondary: "#ffb300",
          accent: "#ff5722",
          error: "#f44336",
          warning: "#ffc107",
          info: "#03a9f4",
          success: "#4caf50"
        }
      }
    },
    icons: {
      iconfont: "mdi"
    }
  }),
  router: new VueRouter({
    routes: [
      {
        path: "/home",
        component: { template: document.querySelector("#home").innerHTML }
      },
      {
        path: "/tasks",
        component: { template: document.querySelector("#tasks").innerHTML }
      },
      {
        path: "/tasks/detail",
        component: {
          template: document.querySelector("#tasks-detail").innerHTML
        }
      },
      {
        path: "/about",
        component: { template: document.querySelector("#about").innerHTML }
      },
      { path: "*", redirect: "/home" }
    ]
  }),
  data: {
    drawer: null
  }
});