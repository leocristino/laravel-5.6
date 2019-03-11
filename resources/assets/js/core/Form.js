import Errors from "./Errors";

class Form {
    constructor(form) {

        this.errors = new Errors();
        this.loading = false;
        this.originalData = {};
        this.data = {};
        this.dataIsSet = false;
    }

    reset() {
        this.data = this.originalData;
    }

    setData(data){

        if(!this.dataIsSet) {
            try {
                this.originalData = Object.assign({} , data);
                this.data = data;
                this.dataIsSet = true;
            }catch (e){
                console.log(e);
            }
        }
    }


    submit(url, onSuccess){
        this.loading = true;

        axios.post(url, this.data)
            .then(response => this.submitHelper(onSuccess, response))
            .catch(error => this.errorHelper(error));
    }

    post(url, params, onSuccess){
        this.loading = true;

        axios.post(url, params)
            .then(response => this.submitHelper(onSuccess, response))
            .catch(error => this.errorHelper(error));
    }

    get(url, params, onSuccess){
        this.loading = true;

        axios.get(url, {params: params})
            .then(response => this.submitHelper(onSuccess, response))
            .catch(error => this.errorHelper(error));
    }

    submitHelper(onSubmit, response){
        onSubmit(response);
        this.loading = false;
    }

    errorHelper(error){
        this.errors.record(error.response.data);
        this.loading = false;
    }

    getdata(){

        let data = Object.assign({} , this);

        return data.data;
    }


}

export default Form;