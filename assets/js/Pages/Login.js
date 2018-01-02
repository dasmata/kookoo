import Vue from "vue";
import LoginForm from "../Components/Login/LoginForm";
import KooKooVue from "../KooKooVue";

Vue.use(KooKooVue);

let vm = new Vue({
    el: "content",
    components: { LoginForm }
});
