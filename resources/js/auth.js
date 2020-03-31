class Auth
{
    constructor() {
        this.apiToken = window.localStorage.getItem('api_token');

        let userData = window.localStorage.getItem('user');
        this.user = userData ? JSON.parse(userData) : null;

        if (this.apiToken) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.apiToken;
        }
    }

    login(apiToken, user) {
        localStorage.setItem('api_token', apiToken);
        localStorage.setItem('user', JSON.stringify(user));

        this.apiToken = apiToken;
        this.user = user;

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.apiToken;
    }

    check() {
        return !! this.apiToken;
    }
}

export default Auth;
