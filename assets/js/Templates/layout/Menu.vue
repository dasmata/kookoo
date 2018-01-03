<template>
    <b-navbar toggleable="md" type="dark" variant="primary">

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand href="#">Kookoo</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse" v-if="identity">

            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown right>
                    <!-- Using button-content slot -->
                    <template slot="button-content">
                        <em>{{ identity.name || identity.username }}</em>
                    </template>
                    <b-dropdown-item href="/profile">Profile</b-dropdown-item>
                    <b-dropdown-item href="/logout">Signout</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>

        </b-collapse>

    </b-navbar>
</template>