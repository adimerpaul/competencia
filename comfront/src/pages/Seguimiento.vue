<template>
<q-page class="q-page-xs">
<q-table title="Historial de registros" :columns="columshistories" :rows="histories">
  <template v-slot:body-cell-evento="props">
    <q-td :props="props" class="text-subtitle2">
      {{props.row.evento.nombre}}
    </q-td>
  </template>
  <template v-slot:body-cell-historial="props">
    <q-td :props="props">
<!--      <div >{{h}}</div>-->
      <q-list dense bordered padding class="text-subtitle2 text-left text-bold">
        <q-item v-for="h in props.row.histories" :key="h.id" clickable v-ripple>
          <q-item-section v-if="h.mstotales!=0">
            {{ h.fecha }}: {{ h.minutos }}m {{ h.segundos }}s {{ h.milisegundos }}ms
          </q-item-section>
          <q-item-section v-else>
            {{ h.fecha }}: <br>
            {{ h.metros1 }}m {{ h.centimetros1 }}cn <br>
            {{ h.metros2 }}m {{ h.centimetros2 }}cn <br>
            {{ h.metros3 }}m {{ h.centimetros3 }}cn <br>
            {{ h.metros4 }}m {{ h.centimetros4 }}cn <br>
            {{ h.metros5 }}m {{ h.centimetros5 }}cn <br>
          </q-item-section>
        </q-item>
      </q-list>
<!--      <template v-if="props.row.histories.mstotales==0">-->
<!--        <pre>{{props.row.histories.metros1}}m {{props.row.histories.centimetros1}}cn</pre> a-->
<!--      </template>-->
<!--      <template v-else>-->
<!--        <pre>{{props.row.histories.minutos}}m {{props.row.histories.segundos}}s {{props.row.histories.milisegundos}}ms</pre>-->
<!--      </template>-->
    </q-td>
  </template>
</q-table>
</q-page>
</template>

<script>
export default {
  name: `Seguimiento`,
  data(){
    return{
      histories:[],
      columshistories:[
        {label:'categoria',name:'categoria',field:'categoria'},
        {label:'evento',name:'evento',field:'evento'},
        {label:'historial',name:'historial',field:'historial'},
      ]
    }
  },
  created() {
    this.mishistories()
  },
  methods:{
    mishistories(){
      this.$q.loading.show()
      this.$api.get('registro/create').then(res=>{
        this.$q.loading.hide()
        this.histories=res.data
      })
    }
  }

}
</script>

<style scoped>

</style>
