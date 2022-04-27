<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12 col-sm-4">
      <q-select outlined dense label="Evento 1" :options="eventos" v-model="evento1" />
    </div>
    <div class="col-12">
      <q-btn class="full-width" icon="check" label="Registrar eventos" color="positive"/>
    </div>
  </div>
</q-page>
</template>

<script>
export default {
  name: `Registrocompetencia`,
  data(){
    return{
      eventos:[{id:0,value:''}],
      evento1: {id:0,value:''},
    }
  },
  created() {
    this.$q.loading.show()
    this.$api.get('evento').then(res=>{
      this.$q.loading.hide()
      res.data
      this.eventos=res.data
    })
  }
}
</script>

<style scoped>

</style>
