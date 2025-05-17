<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <ul v-for="error in errors">
                            <li class="text-danger">{{ error }}</li>
                        </ul>
                        <form  @submit.prevent="login">
                             <div class="mb-3">
                                <label for="inputEmail" class="form-label">Email address</label>
                                <input type="email"  v-model="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="inputPassword" autocomplete="section-blue shipping street-address">
                            </div>
                             
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  
    export default {
        data() {
            return {
                
                email: '',
                password: '',
                errors: []
            }
        },
        methods: {
            login() {
               this.clearMessage();
                axios.get('/sanctum/csrf-cookie').then( () => {
                    axios.post('/api/login', {
                            'email': this.email,
                            'password': this.password
                    },
                    {
                        withCredentials: true
                }).then( response => {
                        const status = true;
                        const token = response.data.token;
                        localStorage.setItem('auth_token', response.data.token);
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token;

                        this.$store.dispatch('checkUserAuthenticationStatus', status);
                        this.$store.dispatch('setAuthToken',token)
                        this.$router.push({
                            name: 'Dashboard' 
                        });
                            
                        if(response.status == 201) {
                            // this.successmessage = response.data.message;
                            console.log(response.data)
                        }
                    }).catch( error => { 
                            console.log(error)
                            if (error.response && error.response.status == 422) {
                                this.errors = Object.values(error.response.data.errors).flat()
                            } else {
                                this.errors = ['Something went wrong']
                            }
                    } );
                });
               
            },
            clearMessage() {
                this.errors = '';
            }
        }
    }
</script>