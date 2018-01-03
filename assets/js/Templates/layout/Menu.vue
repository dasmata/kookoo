<template>
    <b-navbar toggleable="md" type="dark" variant="primary">
        <b-container fluid>

            <b-navbar-brand href="/">KooKoo.ro</b-navbar-brand>

            <template v-if="identity">

                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right no-caret class="nav-item-avatar">
                        <template slot="button-content">
                            <!-- To do: make src relevant -->
                            <img src="https://placekitten.com/g/40/40" v-bind:alt="identity.username" class="rounded-circle">
                        </template>
                        <b-dropdown-header>Hi {{ identity.name || identity.username }}!</b-dropdown-header>
                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-item href="/profile">Profile</b-dropdown-item>
                        <b-dropdown-item href="/logout">Signout</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>

            </template>

        </b-container>
    </b-navbar>
</template>