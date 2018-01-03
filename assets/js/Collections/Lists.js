import {Collection} from 'vue-mc';
import List from '../Models/List';
import {router} from '../routes';

class Lists extends Collection{

    options(){
        return {
            'model': List
        };
    }

    routes(){
        return {
            fetch: router.resolve({name: "get-all-lists"}).href
        };
    }
}

export default Lists;