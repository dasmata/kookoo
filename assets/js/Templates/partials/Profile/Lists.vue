<template>
    <div id="lists-holder">
        <div v-if="lists.length > 0">
            <ul>
                <li v-for="item in lists.models" :class="getListClass(item)">
                    <a href="javascript://" @click="()=>{onClick(item)}">{{ item.name }}</a>
                    (<a href="javascript://" @click="()=>{edit(item)}">edit</a> | <a href="javascript://" @click="()=>{remove(item)}">delete</a>)
                </li>
            </ul>
        </div>
        <div v-else>
            loading...
        </div>
        <div>
            <b-btn variant="primary" v-b-toggle.list-form>Add list</b-btn>
            <b-collapse id="list-form" class="md2" v-model="visibleListForm" @shown="showForm">
                <b-card v-if="saving">
                    Saving...
                </b-card>
                <b-card v-else>
                    <b-form @submit="addList">
                        <b-form-group
                                id="list-name"
                                :class="formErrors.name ? 'has-error has-feedback required' : 'required'"
                                label="Name">
                            <b-form-input
                                    type="text"
                                    v-model="listModel.name"
                                    ref="name"
                                    placeholder="eg. Birthday list"
                            ></b-form-input>
                            <div class="error" v-for="err in formErrors.name">{{ err }}</div>
                        </b-form-group>
                        <b-container fluid>
                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="active-from"
                                            :class="formErrors.activeFrom ? 'has-error has-feedback required' : 'required'"
                                            label="Active From">
                                        <datepicker
                                                name="active_from"
                                                v-model="listModel.activeFrom"
                                                :disabled="disableFromDate"
                                                @selected="activeFrom"
                                        ></datepicker>
                                        <div class="error" v-for="err in formErrors.activeFrom">{{ err }}</div>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            id="active-until"
                                            label="Active Until">
                                        <datepicker
                                                name="active_until"
                                                v-model="listModel.activeUntil"
                                                :disabled="disableUntilDate"
                                                @selected="activeUntil"
                                        ></datepicker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-container>
                        <b-button type="submit" variant="primary">Save list</b-button>
                    </b-form>
                </b-card>
            </b-collapse>
        </div>
    </div>
</template>