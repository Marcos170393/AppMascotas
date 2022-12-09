<template>
    <div class="container">
        <h1 class="display-2">Bienvenido a MascotasApp</h1>
        <div class="container my-5">
            <div class="card m-auto text-center py-2 " style="width: 20rem;">
                <h3 class="display-4">Ingresar</h3>
                <div class="card-body">
                    <form  @submit.prevent="login">
                        <div class="mb-3 text-start">
                          <label  for="email" class="form-label">Email</label>
                          <input v-model="form.email" type="text" name="" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="mb-3 text-start">
                          <label for="pass" class="form-label">Password</label>
                          <input v-model="form.pass" type="password" name="" id="pass" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import {useForm} from '@inertiajs/inertia-vue3';
export default {
    setup(){
        const form = reactive({
        email : "",
        password: "",
    })
    function login(){
        console.log("hola");
           Inertia.post(route('login'),form)
    }
      

        return {form,login}
    }
   
}
</script>