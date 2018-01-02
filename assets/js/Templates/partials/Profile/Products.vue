<template>
    <div id="products-holder" v-show="showSection">
        <div v-if="!products || products.loading">Loading...</div>
        <div v-else-if="products.length === 0">Empty</div>
        <div v-else>
            <b-card-group deck>
                <b-card
                        :class="getProductClass(product)"
                        :no-body="true"
                        :header="product.name"
                        header-tag="header"
                        header-bg-variant="light"
                        header-border-variant="default"

                        style="width:17rem; flex:0 1 auto; margin-bottom:15px;"
                        v-for="product in products.models"
                        :key="product.id"

                        :bg-variant="product.reserved ? 'warning' : 'default'"
                        border-variant="light"

                        footer-bg-variant="light"
                        footer-border-variant="default"
                >
                    <div class="card-text product-card">
                        <div>
                            <a :href="product.url" class="card-link">{{ product.url }}</a>
                        </div>
                        <div>
                            Preference: {{ product.preference }}
                        </div>
                        <div>
                            Price: {{ product.price }} ron
                        </div>
                        <div v-show="product.reserved === 0">
                            Not reserved
                        </div>
                        <div v-show="product.reserved === 1">
                            {{ product.reserver }}
                        </div>
                    </div>
                    <div slot="footer">
                        <b-form-group
                                id="name"
                                v-show="reserve === product"
                                :class="reservationErrors.name ? 'has-error has-feedback required' : 'required'"
                                label="Reserver name">
                            <b-form-input
                                    type="text"
                                    v-model="reserver"
                                    :ref="'reserver'+product.id"
                                    placeholder="John Doe"
                            ></b-form-input>
                            <div class="error" v-for="err in reservationErrors.name">{{ err }}</div>
                        </b-form-group>
                        <b-button variant="danger" @click="()=>{deleteProduct(product)}" v-show="reserve !== product">
                            Delete
                        </b-button>
                        <b-button v-if="product.reserved" variant="warning" @click="()=>{unreserve(product)}">Activate
                        </b-button>
                        <b-button v-else variant="warning" @click="()=>{reserveProduct(product)}">Reserve</b-button>
                        <b-button variant="primary" @click="()=>{edit(product)}" v-show="reserve !== product">Edit
                        </b-button>
                        <b-button variant="danger" @click="()=>{cancelReserve(product)}" v-show="reserve === product">
                            Cancel
                        </b-button>
                    </div>
                </b-card>
            </b-card-group>
        </div>
        <div>
            <b-btn variant="primary" v-b-toggle.product-form>{{ visibleProductForm ? "Cancel" : "Add product" }}</b-btn>
            <b-collapse id="product-form" class="md2" v-model="visibleProductForm" @shown="showForm" @hide="hideForm">
                <b-card v-if="saving">
                    Saving...
                </b-card>
                <b-card v-else>
                    <b-form @submit="addProduct" :novalidate="true">
                        <b-form-group
                                id="product-name"
                                :class="formErrors.name ? 'has-error has-feedback required' : 'required'"
                                label="Name">
                            <b-form-input
                                    type="text"
                                    v-model="model.name"
                                    ref="name"
                                    placeholder="eg. T-Shirt"
                            ></b-form-input>
                            <div class="error" v-for="err in formErrors.name">{{ err }}</div>
                        </b-form-group>
                        <b-form-group
                                id="product-url"
                                :class="formErrors.url ? 'has-error has-feedback required' : 'required'"
                                label="URL">
                            <b-form-input
                                    type="url"
                                    v-model="model.url"
                                    ref="url"
                                    placeholder="eg. http://www.example.com/product.html"
                            ></b-form-input>
                            <div class="error" v-for="err in formErrors.url">{{ err }}</div>
                        </b-form-group>
                        <b-form-group
                                id="product-price"
                                :class="formErrors.price ? 'has-error has-feedback required' : 'required'"
                                label="Price (RON)">
                            <b-form-input
                                    type="number"
                                    v-model="model.price"
                                    ref="number"
                                    step="0.01"
                                    min="0"
                                    placeholder="eg. 39.34"
                            ></b-form-input>
                            <div class="error" v-for="err in formErrors.price">{{ err }}</div>
                        </b-form-group>
                        <b-form-group
                                id="product-preference"
                                :class="formErrors.preference ? 'has-error has-feedback' : ''"
                                :label="'Preference ('+model.preference+')'">
                            <b-form-input
                                    type="range"
                                    v-model="model.preference"
                                    ref="preference"
                                    min="1"
                                    max="10"
                                    step="1"
                                    placeholder="eg. 5"
                            ></b-form-input>
                            <div class="error" v-for="err in formErrors.preference">{{ err }}</div>
                        </b-form-group>
                        <b-button type="submit" variant="primary">Save product</b-button>
                    </b-form>
                </b-card>
            </b-collapse>
        </div>
    </div>
</template>