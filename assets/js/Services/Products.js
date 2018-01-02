import ValidationError from '../Errors/ValidationError';
import Reservation from '../Models/Reservation';

class Products {
    save(model) {
        return model.validate().then((result) => {
            if (!result) {
                throw new ValidationError(model.errors);
            }
            return model.save();
        });
    }

    reserve(product, name) {
        let model = new Reservation({
            "product": product.get("id"),
            "name": name
        });
        return model.validate().then((result) => {
            if (!result) {
                throw new ValidationError(model.errors);
            }
            return model.save().then(() => {
                product.set("reserved", 1);
            });
        });
    }

    unreserve(product) {
        let model = new Reservation({
            "product": product.get("id")
        });
        return model.delete().then(() => {
            product.reserved = 0;
        });
    }

    remove(model) {
        return model.delete();
    }
}

export default new Products();
