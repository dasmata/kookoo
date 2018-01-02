import Vue from 'vue';
import KooKooVue from '../KooKooVue';
import Profile from '../Components/ProfilePage/Profile';
import Lists from '../Components/ProfilePage/Lists';

Vue.use(KooKooVue);

let vm = new Vue({
    el: "content",
    delimiters: ['${', '}'],
    components: { Profile, Lists }
});