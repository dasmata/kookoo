<template>
    <div>
        <b-btn v-b-toggle.collapse1 vaiant="primary">Profile</b-btn>
        <b-collapse id="collapse1" class="md2">
            <b-card>
                <b-form @submit="profileSubmit">
                    <b-form-group
                            id="profile-name"
                            label="Name">
                        <b-form-input
                                type="text"
                                v-model="model.name"
                                placeholder="eg. John Doe"
                        ></b-form-input>
                    </b-form-group>
                    <div>
                        <span>URL: /{{ model.url }}</span>
                        <span v-if="checkingUrl">Checking...</span>
                    </div>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
            </b-card>
        </b-collapse>
    </div>
</template>
