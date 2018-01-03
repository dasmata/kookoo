import Vue from "vue";
import LoginForm from "../../Templates/pages/Login.vue";
import {models} from '../../Models';
import authService from '../../Services/Auth';
import {router} from '../../routes';
import ValidationError from '../../Errors/ValidationError';


LoginForm.data = function () {
    return {
        model: new models.User()
    };
};

LoginForm.methods = {
    onSubmit(e){
        e.preventDefault();
        authService.login(this.$data.model)
            .catch((e) => {
                if (typeof e === "object" && e instanceof ValidationError) {
                    return this.showErrors(e.errors);
                }
            }).then(()=>{
                window.location = router.resolve({name: "profile"}).href;
            });
    },
    showErrors(errors){
        console.log(errors);
    }
};

LoginForm.router = router;

export default LoginForm;