import { createRouter, createWebHistory } from 'vue-router'

// Views
import HomePage from '../views/Home.vue'
import SchemaList from '../views/SchemaList.vue'
import SchemaEdit from '../views/SchemaEdit.vue'
import SchemaCreate from '../views/SchemaCreate.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomePage
  },
  {
    path: '/schemas',
    name: 'SchemaList',
    component: SchemaList
  },
  {
    path: '/schemas/create',
    name: 'SchemaCreate',
    component: SchemaCreate
  },
  {
    path: '/schemas/:id/edit',
    name: 'SchemaEdit',
    component: SchemaEdit,
    props: true
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router