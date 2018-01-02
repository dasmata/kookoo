import Profile from '../../Templates/pages/Profile.vue';
import userService from "../../Services/Auth";
import User from "../../Models/User";

let checkPrm = Promise.resolve();

Profile.data = function () {
    return {
        model: new User(),
        checkingUrl: false,
        validUrl: false
    };
};

Profile.created = function () {
    checkPrm.then(() => {
        return userService.getProfile(this.$data.model);
    });
};

Profile.watch = {
    "model.name": function (newValue) {
        this.$data.model.set('url', newValue.trim().toLowerCase().replace(/\W+/g, "-").replace(/\-$/, ''));
        if (!this.$data.checkingUrl) {
            this.$data.checkingUrl = true;
            setTimeout(() => {
                checkPrm.then(() => {
                    return userService.checkUrl(this.$data.model).then((validUrl) => {
                        this.$data.checkingUrl = false;
                    }).catch(() => {
                        this.$data.checkingUrl = false;
                    });
                })
            }, 1000);
        }
    }
};

Profile.methods = {
    profileSubmit(e){
        e.preventDefault();
        checkPrm.then(() => {
            return userService.save(this.$data.model);
        });
    }
};

export default Profile;