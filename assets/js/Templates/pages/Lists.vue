<template>
        <b-container fluid>
        <b-row>
            <b-col cols="4">
                <lists-partial @select="selectList"></lists-partial>
            </b-col>
            <b-col cols="8">
                <products-partial :list="selectedList"></products-partial>
            </b-col>
        </b-row>
    </b-container>
</template>
