<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Register
                    </div>
                    <div class="card-body">
                        <ul v-for="error in errors">
                            <li class="text-danger">{{ error }}</li>
                        </ul>
                        <div v-if="successmessage"  class="alert alert-success" role="alert" >{{ successmessage }}</div> 
                        <form @submit.prevent="register">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="name" v-model="name" class="form-control" id="name" aria-describedby="nameHelp">
                                 </div>
                            <div class="mb-3">
                                <label for="InputEmail1" class="form-label">Email address</label>
                                <input type="email"  v-model="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="InputPassword1" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="InputPassword1">
                            </div>
                            <div class="mb-3">
                                <label for="ConfirmPassword1" class="form-label">Confirm Password</label>
                                <input type="password" v-model="confirmpassword" class="form-control" id="ConfirmPassword1">
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Register</button>
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
                name: '',
                email: '',
                password: '',
                confirmpassword: '',
                errors: [],
                successmessage: ''
            }
        },
        methods: {
            register() {
                this.clearMessage();
              if (this.password != this.confirmpassword) {
                this.errors = ["Your password does not match with confirmed password."];
                return;
               }
               axios.post('api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
               }).then( response => {
                    this.successmessage = response.data.message;
               }).catch( error => {
                    
                    if (error.response.status == 422 ) {
                        this.errors = Object.values(error.response.data.errors).flat();
                    } else {
                        this.errors = ['Something went wrong'];
                    }
               
               });
               
            },
            clearMessage() {
                this.errors = '';
                this.successmessage = '';
            }
        }
    }
</script>