
let message = "Email address allready in use";

const uniqueEmail = function (value, attribute, object) {
    return new Promise((done, fail) => {
        setTimeout(() => {
            done(message);
        }, 500);
    });
};

uniqueEmail.and = function(rule){
    return function(value, attribute, object){
        return Promise.all([uniqueEmail(value, attribute, object), rule(value, attribute, object)]).then((results)=>{
            return Promise.resolve(results.reduce((result, el)=>{
                if(result === true && el === true){
                    return true;
                } else if(result !== true){
                    return result;
                } else if(el !== true){
                    return el;
                }
            }, true));
        });
    };
};
uniqueEmail.or = function(rule){
    return function(value, attribute, object){
        return Promise.all([uniqueEmail(value, attribute, object), rule(value, attribute, object)]).then((results)=>{
            return Promise.resolve(results.reduce((result, el)=>{
                if(result === true || el === true){
                    return true;
                } else {
                    return result || el;
                }
            }, null));
        });
    };
};
export default uniqueEmail;