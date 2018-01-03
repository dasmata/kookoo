import Abstract from './Abstract';
import Products from '../Collections/Products';
import {router} from  '../routes';
import moment from 'moment';
import {validators} from './index';

class List extends Abstract {

    defaults() {
        return {
            name: "",
            activeFrom: new Date(),
            activeUntil: null
        };
    }

    routes() {
        return {
            save: decodeURIComponent(router.resolve({name: "create-list"}).href),
            delete: decodeURIComponent(router.resolve({name: "list-details", params:{id: "{id}"}}).href),
            fetch: decodeURIComponent(router.resolve({name: "list-details", params:{id: "{id}"}}).href),
        };
    }

    fetchProducts() {
        let collection = new Products();
        collection.setList(this);
        return new Promise((done, fail)=>{
            collection.fetch().then(()=>{
                done(collection);
            });
        });
    }

    getSaveData() {
        let data = super.getSaveData();
        data['activeFrom'] = moment(new Date(data.activeFrom)).format('YYYY-MM-DD');
        data['activeUntil'] = data['activeUntil'] ? moment(new Date(data.activeUntil)).format('YYYY-MM-DD') : null;
        return data;
    }

    validation() {
        return {
            name: [validators.required],
            activeFrom: [validators.required, validators.date],
            activeUntil: validators.empty.or(validators.date)
        };
    }
}

export default List;