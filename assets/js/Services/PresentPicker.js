import Product from "../Models/Product";
import Products from "../Collections/Products";
import ValidationError from "../Errors/ValidationError";

class PresentPicker {
    pickPresent(model) {
        model.products = new Products();
        return model.validate().then((result) => {
            if (!result) {
                throw new ValidationError(model.errors);
            }
            return model.fetchPresent().then((products) => {
                products.sort((a, b) => {
                    let preferenceSort = a.preference - b.preference;
                    let priceSort = (model.get("budget") / parseFloat(b.price)) - (model.get("budget") / parseFloat(a.price));
                    let absPriceSort = Math.abs(priceSort);
                    if (absPriceSort <= 2) {
                        return preferenceSort > 0 ? -1 : (preferenceSort < 0 ? 1 : 0);
                    }
                    if (absPriceSort > 2) {
                        return priceSort > 0 ? -1 : (priceSort < 0 ? 1 : 0);
                    }
                    return 0;
                }).forEach((el) => {
                    model.get('products').add(new Product(el));
                });
            });
        });
    }
}

export default new PresentPicker();