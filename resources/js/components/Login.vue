<template>
    <div class="text-center">
        <div class="form-signin">
            <h1 class="h3 mb-3 font-weight-normal">Вход/Регистрация</h1>

            <label for="login" class="sr-only">Ник</label>
            <input type="email" v-model="nickname" id="login" class="form-control" placeholder="Ник">

            <label for="password" class="sr-only">Пароль</label>
            <input type="password" v-model="password" id="password" class="form-control" placeholder="Пароль">

            <button @click="auth()" class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        </div>
    </div>
</template>

<script>
    import ApiAuth from './../api/authentication';

    export default {
        name: "Login",
        data() {
            return {
                nickname: null,
                password: null
            }
        },
        mounted() {
            //
        },
        methods: {
            auth () {
                let data = {
                    nickname: this.nickname,
                    password: this.password
                }

                ApiAuth.authentication(data)
                    .then((response) => {
                        auth.login(response.data.api_token, response.data.data);

                        this.$router.push('/');
                    });
            }
        }
    }
</script>

<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
