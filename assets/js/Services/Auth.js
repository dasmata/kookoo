import ValidationError from '../Errors/ValidationError';

class Auth {
    login(model) {
        return model.validate().then((result) => {
            console.log(model.errors);
            if (!result) {
                throw new ValidationError(model.errors);
            }
            return model.auth();
        });
    }

    checkUrl(model) {
        return model.checkUrl().then((data) => {
            model.set("url", data.url);
        });
    }

    save(model) {
        return model.save();
    }

    getProfile(model) {
        return model.fetch();
    }
}

export default new Auth();