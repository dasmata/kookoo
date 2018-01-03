import Menu from "../../Templates/layout/Menu.vue";

Menu.data = function(){
    return {
        identity: app.user,
    };
};



export default Menu;
