import List from '../../Models/List';
import ListsCollection from '../../Collections/Lists';
import listService from '../../Services/Lists';
import Datepicker from 'vuejs-datepicker';
import ListsPartial from '../../Templates/partials/Profile/Lists.vue';

let lists = new ListsCollection();
ListsPartial.data = function () {
    return {
        lists: lists,
        listModel: new List(),
        disableFromDate: {
            to: new Date()
        },
        disableUntilDate: {
            to: new Date()
        },
        visibleListForm: false,
        formErrors: {},
        selected: null,
        deleting: null,
        saving: false
    };
};
ListsPartial.created = function () {
    lists.fetch().then(() => {
        this.selectList(lists.first());
    });
};

ListsPartial.methods = {
    onClick(list){
        this.selectList(list);
    },
    selectList(list){
        this.$data.selected = list;
        this.$data.visibleListForm = false;
        this.$emit('select', list);
    },
    addList(e){
        e.preventDefault();
        this.$data.saving = true;
        listService.save(this.$data.listModel)
            .then(() => {
                lists.add(this.$data.listModel);
                this.$data.listModel = new List();
                this.$data.visibleListForm = false;
                this.$data.saving = false;
                if (lists.length === 1) {
                    this.selectList(lists.first());
                }
            })
            .catch((error) => {
                this.$data.saving = false;
                let errs = {};
                Object.keys(error.errors).forEach((key) => {
                    errs[key] = error.errors[key];
                });
                this.$data.formErrors = errs;
            });
    },
    activeFrom(date){
        this.$set(this.disableUntilDate, "to", date);
    },
    activeUntil(date){
        this.$set(this.disableFromDate, "from", date);
    },
    showForm(){
        this.$refs.name.$el.focus();
    },
    remove(list){
        this.$data.deleting = list;
        this.confirmDelete(list).then(() => {
            listService.remove(list).then(() => {
                this.$emit('select', list);
                if (list === this.$data.selected && lists.length > 0) {
                    this.selectList(lists.first());
                }
            });
        }).catch(() => {
            this.$data.deleting = null;
        });
    },
    confirmDelete(list){
        return new Promise((done, fail) => {
            setTimeout(() => {
                if (confirm("Are you sure you want to delete the list " + list.name + "?")) {
                    done();
                } else {
                    fail();
                }
            }, 500);
        });
    },
    edit(list){
        this.$data.listModel = list;
        this.$data.visibleListForm = true;
    },
    hideForm(){
        this.$data.listModel.reset();
        this.$data.listModel = new List();
    },
    getListClass(list){
        let className = '';
        if (this.$data.deleting === list) {
            className += " deleting";
        }
        if (this.$data.selected === list) {
            className += " selected";
        }
        return className;
    }
};

ListsPartial.components = {Datepicker};
export default ListsPartial;