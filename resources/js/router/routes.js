const routes = [
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
