import Product from '../../Models/Product';
import ProductsPartial from '../../Templates/partials/Profile/Products.vue';
import ProductsCollection from '../../Collections/Products';
import productService from '../../Services/Products';
import ValidationError from '../../Errors/ValidationError';


ProductsPartial.data = function () {
    return {
        products: new ProductsCollection(),
        visibleProductForm: false,
        model: this.createModel(),
        formErrors: {},
        deleting: false,
        showSection: true,
        saving: false,
        reserve: false,
        reserver: '',
        reserving: null,
        reservationErrors: {}
    }
};

ProductsPartial.props = ['list'];
ProductsPartial.watch = {
    list: function (newVal, oldVal) {
        if (newVal) {
            this.$data.showSection = true;
            this.$data.products = new ProductsCollection();
            this.$data.model = this.createModel();
            this.updateProducts(newVal);
        } else {
            this.$data.showSection = false;
        }

    }
};

ProductsPartial.methods = {
    createModel(){
        return new Product({
            preference: 5,
            list: this.$props.list ? this.$props.list.id : null
        })
    },
    updateProducts(list){
        list.fetchProducts().then((collection) => {
            this.$data.products.add(collection.models);
        });
    },
    showForm(){
        this.$refs.name.$el.focus();
    },
    addProduct(e){
        e.preventDefault();
        this.$data.saving = true;
        productService.save(this.$data.model)
            .then(() => {
                this.$data.products.add(this.$data.model);
                this.$data.model = this.createModel();
                this.$data.visibleProductForm = false;
                this.$data.saving = false;
            })
            .catch((error) => {
                let errs = {};
                this.$data.saving = false;
                Object.keys(error.errors).forEach((key) => {
                    errs[key] = error.errors[key];
                });
                this.$data.formErrors = errs;
            });
    },
    deleteProduct(product){
        this.$data.deleting = product;
        this.confirmDelete(product).then(() => {
            productService.remove(product);
        }).catch(() => {
            this.$data.deleting = null;
        });
    },
    confirmDelete(product){
        return new Promise((done, fail) => {
            setTimeout(() => {
                if (confirm("Are you sure you want to delete the product " + product.name + "?")) {
                    done();
                } else {
                    fail();
                }
            }, 500);
        });
    },
    getProductClass(product){
        if (this.$data.reserving === product) {
            return "reserving";
        }
        if (this.$data.deleting === product) {
            return "deleting";
        }
        return null;
    },

    cancelReserve(){
        this.$data.reserve = null;
    },

    reserveProduct(product){
        if(this.$data.reserve !== product){
            this.$data.reserve = product;
            this.$nextTick(()=>{
                this.$refs['reserver' + product.id][0].$el.focus();
            });
            return;
        }

        this.$data.reservationErrors = {};
        this.$data.reserving = product;
        productService.reserve(product, this.$data.reserver).then(()=>{
            this.$data.reserve = null;
            this.$data.reserving = null;
            product.set("reserver", this.$data.reserver);
            this.$data.reserver = '';
        }).catch((err)=>{
            this.$data.reserving = null;
            if(err instanceof ValidationError){
                this.$data.reservationErrors = err.errors;
            }
        });
    },
    unreserve(product){
        productService.unreserve(product);
    },
    edit(product){
        this.$data.model = product;
        this.$data.visibleProductForm = true;
    },
    hideForm(){
        this.$data.model.reset();
        this.$data.model = this.createModel();
    }
};

export default ProductsPartial;