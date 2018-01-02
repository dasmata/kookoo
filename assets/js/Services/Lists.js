import ValidationError from '../Errors/ValidationError';

class Lists {
    save(model) {
        return model.validate().then((result) => {
            if (!result) {
                throw new ValidationError(model.errors);
            }
            return model.save();
        });
    }

    remove(model) {
        return model.delete();
    }
}

export default new Lists();