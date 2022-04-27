<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          {{$store.getters["login/user"].nombres}} {{$store.getters["login/user"].paterno}} {{$store.getters["login/user"].materno}}
        </q-toolbar-title>

        <div>
          <q-btn v-if="$store.getters['login/isLoggedIn']" size="xs" icon="logout" label="salir" @click="logout" color="negative"/>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label header>Opciones
        </q-item-label>
        <q-item  clickable exact to="/">
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Principal</q-item-label>
            <q-item-label caption>
              Principal al sistema
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item v-if="!$store.getters['login/isLoggedIn']" clickable exact to="/login">
          <q-item-section avatar>
            <q-icon name="login" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Ingresar</q-item-label>
            <q-item-label caption>
              Ingresar al sistema
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="registrocompetencia" exact v-if="$store.getters['login/user'].tipo=='ADMINISTRADOR'">
          <q-item-section avatar>
            <q-icon name="document_scanner" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Registro de competencias </q-item-label>
            <q-item-label caption>Registro de competencias</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="registro" exact v-if="$store.getters['login/user'].tipo=='ADMINISTRADOR'">
          <q-item-section avatar>
            <q-icon name="app_registration" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Registro a evento </q-item-label>
            <q-item-label caption>Registro a evento</q-item-label>
          </q-item-section>
        </q-item>
        <q-item v-if="$store.getters['login/isLoggedIn']" clickable @click="logout">
          <q-item-section avatar>
            <q-icon name="logout" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Salir</q-item-label>
            <q-item-label caption>
              Salir del sistema
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  data(){
    return{
      leftDrawerOpen:false,
    }
  },
  created() {
    // console.log()
  },
  methods:{
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    logout () {
      this.$q.loading.show()
      this.$store.dispatch('login/logout')
        .then(() => {
          this.$q.loading.hide()
          this.$router.push('/login')
        })
    },
  }
}
</script>
