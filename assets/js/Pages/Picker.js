import Vue from "vue";
import KooKooVue from "../KooKooVue";
import Picker from "../Models/Picker";
import pickerService from "../Services/PresentPicker";
import productsService from "../Services/Products";
import ValidationError from "../Errors/ValidationError";

Vue.use(KooKooVue);

let vm = new Vue({
    el: "#picker",
    data: {
        picker: new Picker(),
        present: null,
        reserve: false,
        reseveText: 'I want to reserve this',
        name: '',
        reserving: false,
        loading: false,
        submited: false,
        errors: {}
    },
    mounted: function () {
        this.$nextTick(() => {
            this.$el.style.visibility = "visible";
        });
    },
    methods: {
        pickPresent(e){
            e.preventDefault();
            this.$data.loading = true;
            this.$data.submited = true;
            this.$data.errors = {};
            pickerService.pickPresent(this.$data.picker).then(() => {
                this.nextPresent();
                this.$data.loading = false;
            }).catch((error) => {
                if (error instanceof ValidationError) {
                    this.$data.errors = error.errors;
                }
                this.$data.loading = false;
                this.$data.submited = false;
            });
        },
        nextPresent(){
            this.$data.present = this.$data.picker.products.shift();
        },
        reservePresent(product){
            if (!this.$data.reserve) {
                this.$data.reserve = !this.$data.reserve;
                this.$data.reseveText = 'Reserve';
                return;
            }
            this.$data.reserving = true;
            this.$data.errors = {};
            productsService.reserve(product, this.$data.name).then(() => {
                this.$data.reserving = false;
            }).catch((error) => {
                if (error instanceof ValidationError) {
                    this.$data.errors = error.errors;
                }
                this.$data.errors = error.errors;
                this.$data.reserving = false;
            });
        },
    },
    delimiters: ['${', '}']
});