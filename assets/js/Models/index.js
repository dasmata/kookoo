import uniqueEmail from '../Validators/UniqueEmail';
import {
    boolean,
    equal,
    numeric,
    min,
    required,
    string,
    empty,
    email,
    date,
    after,
    before,
    url,
    gt,
    uuid
} from 'vue-mc/validation';


import User from './User';

const models = {
    User
};

const validators = {
    uniqueEmail,
    boolean,
    equal,
    numeric,
    min,
    required,
    string,
    empty,
    email,
    date,
    after,
    before,
    url,
    gt,
    uuid
};

export {models};
export {validators};