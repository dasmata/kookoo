import {Collection} from 'vue-mc';
import Product from '../Models/Product';
import {router} from '../routes';

class Products extends Collection {

    options() {
        return {
            'model': Product
        }
    }

    routes() {
        return {
            fetch: router.resolve({name: "get-lists-products"}).href,
            pickPresent: decodeURIComponent(router.resolve({name: "pick-present"}).href)
        }
    }

    getFetchQuery() {
        let list = this.getList();
        let query = super.getFetchQuery();
        if (list) {
            return Object.assign({}, query, {list: this.getList().id})
        }
        return query;
    }

    setList(list) {
        this.list = list;
    }

    getList() {
        return this.list;
    }

    pickPresent(budget, userId) {
        let config = {
            url: this.getURL(this.routes().pickPresent),
            method: "GET",
            params: {
            budget: budget,
            user: userId
            },
            headers: {
                "Content-Type": "application/json;charset=UTF-8"
            },
        };
        return this.getRequest(config).send().then((data) => {
            if(data.response.status === 200){
                return data.response.data;
            }
            return [];
        }).catch((error) => {
            console.log(error);
            throw Error();
        });
    }
}

export default Products;