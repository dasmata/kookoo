import {Model} from 'vue-mc';

class Abstract extends Model{
        validate(attributes) {
        let toValidate;
        if (typeof attributes === "string") {
            return this.validateAttribute(attributes);
        }
        if (typeof attributes === "object" && attributes.constructor === Array) {
            toValidate = attributes;
        } else {
            toValidate = Object.keys(this._attributes);
        }
        return Promise.all(toValidate.map((attribute) => {
            return this.validateAttribute(attribute);
        })).then((data) => {
            return Boolean(data.reduce((sum, result) => {
                return sum & result;
            }, true));
        });
    }

    validateAttribute(attribute) {
        let value = this.get(attribute);
        let rules = this.validation();
        if (!(attribute in rules)) {
            return Promise.resolve(true);
        }
        if(rules[attribute].constructor !== Array){
            return Promise.resolve(rules[attribute](value, attribute, this));
        }

        return Promise.all(rules[attribute].map((rule) => {
            return rule(value, attribute, this);
        })).then((values) => {
            return values.reduce((sum, result) => {
                if (sum !== true) {
                    return sum;
                }
                if (result !== true) {
                    this.setAttributeErrors(attribute, [result]);
                }
                return result;
            }, true);
        });
    }

}


export default Abstract;