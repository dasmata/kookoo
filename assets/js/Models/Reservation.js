import Abstract from "./Abstract";
import {validators} from "./index";
import {router} from "../routes";

class Reservation extends Abstract{

    defaults() {
        return {
            name: "",
            product: ""
        };
    }

    routes() {
        return {
            save: decodeURIComponent(router.resolve({name: "create-reservation"}).href),
            delete: decodeURIComponent(router.resolve({name: "delete-reservation", params:{id: '{product}'}}).href)
        };
    }

    validation() {
        return {
            name: [validators.required],
            product: [validators.required, validators.uuid]
        };
    }

}

export default Reservation;