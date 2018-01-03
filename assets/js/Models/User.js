import Abstract from './Abstract';
import {validators} from './index';
import {router} from  '../routes';

class User extends Abstract {
    defaults() {
        return {
            username: "",
            password: "",
            name: "",
            url: ""
        };
    }

    routes() {
        return {
            login: router.resolve({"name": "login"}).href,
            checkUrl: router.resolve({"name": "check-url"}).href,
            update: router.resolve({"name": "update-profile"}).href,
            save: router.resolve({"name": "update-profile"}).href,
            fetch: router.resolve({"name": "get-profile"}).href
        };
    }

    validation() {
        return {
            username: [validators.required],
            password: [validators.required]
        };
    }

    auth() {
        let config = {
            url: this.getURL(this.routes().login),
            method: "POST",
            data: {
                "username": this.get("username"),
                "password": this.get("password")
            },
            headers: {
                "Content-Type": "application/json;charset=UTF-8"
            }
        };
        return this.getRequest(config).send().then((data) => {
            console.log(data);
        }).catch((error) => {
            throw new Error(error);
        });
    }

    checkUrl() {
        let config = {
            url: this.getURL(this.routes().checkUrl),
            method: "GET",
            params: {
                "url": this.get("url")
            },
            headers: {
                "Content-Type": "application/json;charset=UTF-8"
            },
        };
        return this.getRequest(config).send().then((data) => {
            if(data.response.status === 200){
                return data.response.data;
            }
        }).catch((error) => {
            throw new Error(error);
        });
    }
}

export default User;