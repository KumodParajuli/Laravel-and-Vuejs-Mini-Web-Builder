import {
    createStore
} from "vuex";
import axios from "axios";

export default createStore({

    state: {
        token: localStorage.getItem('token') || '',
        isAuthenticated: localStorage.getItem('isAuthenticated') === 'true',
        status: localStorage.getItem('isAuthenticated') === 'true'
    },

    mutations: {

        // UpdateAuthenticationStatus (state, status) {
        //     state.status = status;
        //     localStorage.setItem('isAuthenticated',status)
        // },

        UpdateAuthStatus(state, status) {
            state.status = status;
            localStorage.setItem('isAuthenticated', status)
        },

        UpdateToken(state, token) {
            state.token = token
            localStorage.setItem('token', token)
        },

        resetAuth(state) {
            state.token = null
            state.isAuthenticated = false
        }

    },

    actions: {

        checkUserAuthenticationStatus({
            commit
        }) {
            // api/authenticaton
            axios.get('api/auth-status')
                .then(response => {
                    commit('UpdateAuthStatus', response.data.status)
                    //    commit('UpdateAuthenticationStatus',response.data.isAuthenticated)
                })
                .catch(error => {
                    console.log(error)
                })
        },

        SetAuthStatus({
            commit
        }, status) {
            commit('UpdateAuthStatus', status);
            // commit('UpdateAuthenticationStatus',status);
        },

        setAuthToken({
            commit
        }, token) {
            commit('UpdateToken', token)
        },

        logout({
            commit
        }, status) {
            commit('resetAuth')
            localStorage.removeItem('token')
            localStorage.removeItem('isAuthenticated')
            delete axios.defaults.headers.common['Authorization']
            commit('UpdateAuthStatus', status);
        }

    },
    getters: {

        authStatus: state => state.isAuthenticated

    }
});
