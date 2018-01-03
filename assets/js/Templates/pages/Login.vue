<template>
    <div id="login-form" class="d-flex-center form-group-lg">
        <b-form action="/login" method="post" @submit="onSubmit" :novalidate=true class="form-login">

            <b-form-group id="username"
                label="Username"
                label-for="username">
                <b-form-input id="username"
                    type="text"
                    name="_username"
                    v-model="model.username">
                </b-form-input>
            </b-form-group>
            <b-form-group id="password"
                label="Password"
                label-for="password">
                <b-form-input id="exampleInput1"
                    type="password"
                    v-model="model.password"
                    name="_password">
                </b-form-input>
            </b-form-group>

            <div class="d-flex justify-content-between align-items-center">
                <b-button type="submit" variant="primary">Login</b-button>
                <a href="/register">Create account</a>
            </div>

        </b-form>
    </div>
</template>