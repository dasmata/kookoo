<template>
    <div class="center" id="login-form">
        <div class="col-sm-3 form-group-lg">
            <b-form action="/login" method="post" @submit="onSubmit" :novalidate=true>
                <b-form-group id="email"
                              label="Email address:"
                              label-for="username"
                              description="">
                    <b-form-input id="username"
                                  type="email"
                                  name="_username"
                                  v-model="model.email"
                                  placeholder="john.doe@example.com">
                    </b-form-input>
                </b-form-group>
                <b-form-group id="password"
                              label="Password:"
                              label-for="password"
                              description="">
                    <b-form-input id="exampleInput1"
                                  type="password"
                                  v-model="model.password"
                                  name="_password"
                                  placeholder="Your account password">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <b-button type="submit" variant="primary">Login</b-button>
                    <a href="/register">Create account</a>
                </b-form-group>
            </b-form>
        </div>
    </div>
</template>