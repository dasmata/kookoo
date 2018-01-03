import Abstract from './Abstract';
import {router} from '../routes';
import {validators} from './index';

class Product extends Abstract {

    mutations() {
        return {
            reserved: (r) => {
                return + r;
            }
        };
    }

    defaults() {
        return {
            id: null,
            name: "",
            url: "",
            price: "",
            reserved: 0,
            preference: "",
            reserver: ""
        };
    }

    routes() {
        return {
            save: decodeURIComponent(router.resolve({name: "create-product"}).href),
            delete: decodeURIComponent(router.resolve({name: "product-details", params:{id: '{id}'}}).href),
            fetch: decodeURIComponent(router.resolve({name: "product-details", params:{id: '{id}'}}).href)
        };
    }

    validation() {
        return {
            name: validators.required,
            url: validators.required.and(validators.url),
            price: validators.required.and(validators.numeric)
        };
    }
}

export default Product;