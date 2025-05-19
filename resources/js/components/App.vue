<template>  
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body"  data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Web Builder</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          
            <li class="nav-item" v-if="isAuthenticated">
                <router-link to="/pages" class="nav-link  " aria-current="page" >Site Pages</router-link>
            </li>
            <li class="nav-item" v-if="isAuthenticated">
                <router-link to="/settings" class="nav-link  " aria-current="settings" >Site Setting</router-link>
            </li>
            <li class="nav-item" v-if="isAuthenticated">
                <router-link to="/navigation" class="nav-link  " aria-current="navigation" >Site Menu</router-link>
            </li>
            
        </ul>
        </div>
        <div class="d-flex">
            <router-link v-if="isAuthenticated" to="/dashboard" class="btn btn-outline-success m-1" aria-current="page" >Dashboard</router-link>
            <a href="#"  @click.prevent="logout" v-if="isAuthenticated" class="btn btn-outline-danger m-1" >Logout</a>
            <router-link v-if="!isAuthenticated" to="/login" class="btn btn-outline-primary  m-1  " aria-current="page" >Login</router-link>
            <router-link v-if="!isAuthenticated" to="/register" class="btn btn-outline-primary  m-1 " aria-current="page" >Register</router-link>
        </div>
    </div>
    </nav>
 
    <router-view> </router-view>
</template>

<script>
    import { mapGetters } from 'vuex';
    import axios from '../axios.js';
    export default {
         mounted() {
            
            //this.$store.dispatch('UpdateAuthStatus'); 

        },
        computed: {

            isAuthenticated(){
                return this.$store.state.status;
            }, 
            authToken(){
                return this.$store.state.token;
            },
            
        },
        
       
        methods: {
            logout() { 
                axios.post('api/logout')
                .then( response => {
                   this.$store.dispatch('logout')

                   this.$router.push({
                    name: 'Login'
                   }); 
                }).catch( error => {
                     console.log(error)
                });
            }
        }
    }
</script>