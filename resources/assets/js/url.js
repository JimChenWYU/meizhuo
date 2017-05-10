/**
 * Created by lenovo on 2017/4/3.
 */

(function (global, factory) {
    typeof module !== 'undefined' && typeof module.exports === 'object' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
        (global.Vue = factory());
}(this, (function () { 'use strict';
    const DEV_URL = "http://meizhuo.app";
    const PRO_URL = "";
    const BASE_URL = (process.env.NODE_ENV != 'production') ? DEV_URL : PRO_URL;

    return {
        apply: BASE_URL + '/api/v1/apply',
        signers: BASE_URL + '/api/v1/signers',
        sign: BASE_URL + '/api/v1/sign'
    }
})))