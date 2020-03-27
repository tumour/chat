import VueRouter from 'vue-router';
import Login from "../components/Login";
import NotFound from "../components/NotFound";
import Index from "../components/Index";

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            guest: true
        }
    },
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            auth: true
        }
    },
    {
        path: '*',
        component: NotFound
    },
];

const router =  new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (localStorage.getItem('api_token') == null) {
            next({
                name: 'login',
            });
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (localStorage.getItem('api_token') == null) {
            next();
        } else {
            next({ name: 'chat'})
        }
    }

    next();
});

export default router;
