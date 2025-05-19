<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Welcome <span  v-if="user">{{ user.name  }} </span> !
                    </div>
                    <div  class="card-body"> 
                         <p class="card-text">The "Pages" section allows you to design and add new pages to your website, customizing the content and layout as needed. The "Settings" section is where you can manage overall site configurations such as the site logo, title, navigation menu, and other global options. This system is very simple to use and is ideal for building and managing a basic website with ease.</p>
            
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {

        data() {
            return {
                user: null
            }
        },
        mounted() {
            if (this.authToken) {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.auth}`;
            }
            this.getUserDetails();
        },
        methods: {
            getUserDetails() {
                axios.get('api/user')
                .then( response => {
                    this.user = response.data
                } )
                .catch( error => {

                })
            }
        }
    }
</script>