import BootstrapVue from 'bootstrap-vue';
import {router} from './routes';

const KooKooVue = {

    install(Vue, options){
        Vue.use(BootstrapVue);
        Vue.use(router);
        Vue.delimiters = ['${', '}'];
    }

};

export default KooKooVue;