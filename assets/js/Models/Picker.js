import Abstract from "./Abstract";
import {validators} from "./index";

class Picker  extends Abstract{
    defaults(){
        return {
            products: null,
            budget: "",
            user: picker.user.id
        };
    }

    validation(){
        return {
            budget: [validators.required, validators.numeric, validators.gt(0)]
        };
    }

    fetchPresent(){
        return this.products.pickPresent(this.get("budget"), this.get("user"));
    }
}
export default Picker;
