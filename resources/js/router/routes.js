const routes = [
    {
        path: "/auth",
        component: () => import("../layouts/AuthLayout.vue"),
        children: [
            {path: "register", component: () => import("../pages/Auth/RegisterPage.vue")},
            {path: "login", component: () => import("../pages/Auth/LoginPage.vue")},
        ],
        meta: {requiresNotAuth: true},
    },
    {
        path: "/",
        component: () => import("../layouts/MainLayout.vue"),
        children: [
            {
                path: "",
                component: () => import("../pages/HomePage.vue"),
            },
            {
                path: "packages",
                name: "IndexPackages",
                component: () => import("../pages/Packages/IndexPage.vue"),
            },
        ],
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/:catchAll(.*)*",
        component: () => import("../pages/NotFoundPage.vue"),
    },
];

export default routes;
