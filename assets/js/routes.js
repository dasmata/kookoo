import VueRouter from "vue-router";

const routes = [
    {path: Routing.generate("profile"), name: 'profile'},
    {path: Routing.generate("login"), name: 'login'},
    {path: Routing.generate("logout"), name: 'logout'},
    {path: Routing.generate("check-url"), name: 'check-url'},
    {path: Routing.generate("update-profile"), name: 'update-profile'},
    {path: Routing.generate("get-profile"), name: 'get-profile'},

    {path: Routing.generate("get-all-lists"), name: 'get-all-lists'},
    {path: Routing.generate("create-list"), name: 'create-list'},
    {path: decodeURIComponent(Routing.generate("get-list", {id: ':id'})), name: 'list-details'},

    {path: Routing.generate("get-list-products"), name: 'get-lists-products'},
    {path: Routing.generate("create-product"), name: 'create-product'},
    {path: decodeURIComponent(Routing.generate("get-product", {id: ':id'})), name: 'product-details'},

    {path: Routing.generate("create-reservation"), name: 'create-reservation'},
    {path: decodeURIComponent(Routing.generate("delete-reservation", {id: ':id'})), name: 'delete-reservation'},

    {path: '/:alias', name: 'picker'},
    {path: Routing.generate("pick-present"), name: 'pick-present'},
];

let router = new VueRouter({
    routes,
    mode: 'history'
});

export default routes;
export {router};