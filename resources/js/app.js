import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-sweetalert/dist/sweetalert.js";
import "bootstrap-sweetalert/dist/sweetalert.css";

Vue.use(BootstrapVue);

// Component File
import App from "./components/App";

const app = new Vue({
    el: "app",
    render: h => h(App)
});

export default app;
