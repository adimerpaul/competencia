import Login from "pages/Login";
import Player from "pages/Player";
import Registro from "pages/Registro";
import Registrocompetencia from "pages/Registrocompetencia";
import Seguimiento from "pages/Seguimiento";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      { path: 'login', component:Login },
      { path: 'player', component:Player,meta: {requiresAuth: true,} },
      { path: 'registro', component:Registro,meta: {requiresAuth: true,} },
      { path: 'seguimiento', component:Seguimiento,meta: {requiresAuth: true,} },
      { path: 'registrocompetencia', component:Registrocompetencia,meta: {requiresAuth: true,} },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
