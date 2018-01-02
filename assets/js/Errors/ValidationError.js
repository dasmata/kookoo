class ValidationError{

    constructor(errors){
        this._errors = errors;
    }

    get errors(){
        return this._errors;
    }
}

export default ValidationError;