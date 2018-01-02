require('bootstrap/dist/css/bootstrap.css');
require('bootstrap-vue/dist/bootstrap-vue.css');
import Menu from './Components/Generic/Menu';
import Vue from 'vue';
import KookooVue from './KooKooVue';

Vue.use(KookooVue);

let headerVm = new Vue({
    el: "header",
    components: { topMenu: Menu }
});
