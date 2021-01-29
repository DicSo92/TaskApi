<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">Courriel</label>
                    <input id="email" type="text" name="email" placeholder="Entrez votre adresse e-mail" class="form-control" v-model="email"/>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="text" name="password" placeholder="Entrez votre mot de passe" class="form-control" v-model="password"/>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading" @click.prevent="login">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return { email: null, password: null, errors: null, loading: false}
        },
        methods: {
            async login() {
                this.loading = true;
                this.errors = null;
                try {
                    await axios.get('sanctum/csrf-cookie');
                    await axios.post("login", {
                        email: this.email,
                        password: this.password
                    })
                } catch (error) {
                    this.errors = error.response && error.response.data.errors;
                }
                this.loading = false;
            }
        }
    }
</script>

<style scoped>

</style>
