const routes = [
    {
        path: "/auth",
        component: () => import("../layouts/AuthLayout.vue"),
        children: [
            {path: "register", component: () => import("../pages/Auth/RegisterPage.vue")},
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
