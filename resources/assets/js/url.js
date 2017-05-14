/**
 * Created by lenovo on 2017/4/3.
 */

(function (global, factory) {
    typeof module !== 'undefined' && typeof module.exports === 'object' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
        (global.Vue = factory());
}(this, (function () { 'use strict';
    let config = require('./config.json');
    const BASE_URL = (process.env.NODE_ENV != 'production') ?
        config.url.base_url.dev : config.url.base_url.prod;
    const BASE_SOCKET_URL = (process.env.NODE_ENV != 'production') ?
        config.url.base_socket_url.dev : config.url.base_socket_url.prod;

    // url维护
    return {
        base_url: BASE_URL,
        base_socket_url: BASE_SOCKET_URL,
        apply: BASE_URL + '/api/v1/apply',
        signers: BASE_URL + '/api/v1/signers',
        delSigner: BASE_URL + '/api/v1/signer',
        sign: BASE_URL + '/api/v1/sign',
        interview: BASE_URL + '/api/v1/interview',
        interviewAuto: BASE_URL + '/api/v1/interview/autologin',
        interviewOut: BASE_URL + '/api/v1/interview',
        interviewSearch: BASE_URL + '/api/v1/interview/search',
        interviewBegin: BASE_URL + '/api/v1/interview/signer'
    }
})))