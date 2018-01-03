import ListsPartial from "./ProductsLists";
import ProductsPartial from "./Products";
import Lists from '../../Templates/pages/Lists.vue';



Lists.components = {ListsPartial, ProductsPartial};
Lists.data = function () {
    return {
        selectedList: null
    };
};
Lists.methods = {
    selectList(list){
        this.$data.selectedList = list;
    }
};


export default Lists;