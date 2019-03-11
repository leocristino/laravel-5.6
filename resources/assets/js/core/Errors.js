class Errors{
    constructor(){
        this.errors = {};
    }

    get(field){
        if(this.errors[field]){
            return  this.errors[field][0];
        }
    }

    record(errors){
        this.errors = errors;
    }

    any(){
        return Object.keys(this.errors).length > 0;
    }

    has(field){
        return this.errors.hasOwnProperty(field);
    }

    clear(field){
        if(field) delete this.errors[field];

        this.errors = {};
    }



}

export default Errors;