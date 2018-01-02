
let message = "Email address allready in use";

const uniqueEmail = function (value, attribute, object) {
    return new Promise((done, fail) => {
        setTimeout(() => {
            done(true);
        }, 500);
    })
};

export default uniqueEmail;