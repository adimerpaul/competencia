<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-card flat bordered>
        <q-card-section class="q-pa-none text-center text-subtitle2">Datos Competidor</q-card-section>
        <q-separator></q-separator>
        <q-card-section class="q-pa-none">
          <div class="row">
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="paterno"  v-model="$store.getters['login/user'].paterno" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="materno"  v-model="$store.getters['login/user'].materno" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="nombres"  v-model="$store.getters['login/user'].nombres" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="licencia"  v-model="$store.getters['login/user'].licencia" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="genero"  v-model="$store.getters['login/user'].genero" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="carnet"  v-model="$store.getters['login/user'].carnet" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input type="date" :disable="true" outlined  label="fechanac"  v-model="$store.getters['login/user'].fechanac" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="edad"  :model-value="edad($store.getters['login/user'].fechanac)" />
            </div>
            <div class="col-4 col-sm-2">
              <q-input :disable="true" outlined  label="categoria"  v-model="categoria" />
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
    <div class="col-12">
      <q-card flat bordered>
        <q-card-section class="q-pa-none text-center text-subtitle2">Registro a eventos</q-card-section>
        <q-separator></q-separator>
        <q-card-section class="q-pa-none">
          <q-form @submit.prevent="createRegistro">
          <div class="row">
            <div class="col-6 col-sm-4">
              <q-select :disable="!$store.getters['login/user'].verificado==0" outlined  label="Seleccionar Evento 1" :options="eventos" v-model="evento1" />
            </div>
            <div class="col-6 col-sm-4">
              <q-select :disable="!$store.getters['login/user'].verificado==0" outlined  label="Seleccionar Evento 2" :options="eventos" v-model="evento2" />
            </div>
            <div class="col-6 col-sm-4">
              <q-select :disable="!$store.getters['login/user'].verificado==0" outlined  label="Seleccionar Evento 3" :options="eventos" v-model="evento3" />
            </div>
            <div class="col-6 col-sm-4">
              <q-select :disable="!$store.getters['login/user'].verificado==0" outlined  label="Seleccionar Evento 4" :options="eventos" v-model="evento4" />
            </div>
            <div class="col-6 col-sm-4">
              <q-select :disable="!$store.getters['login/user'].verificado==0" outlined  label="Seleccionar Evento 5" :options="eventos" v-model="evento5" />
            </div>
            <div class="col-6 col-sm-4">
              <q-select :disable="!$store.getters['login/user'].verificado==0" outlined  label="Seleccionar Evento 6" :options="eventos" v-model="evento6" />
            </div>
            <div class="col-12">
              <q-btn type="submit" :disable="!$store.getters['login/user'].verificado==0" class="full-width" icon="check" label="Registrar eventos" color="positive"/>
            </div>
          </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </div>
</q-page>
</template>

<script>
import moment from "moment";

export default {
  name: `Registrocompetencia`,
  data(){
    return{
      eventos:[],
      evento1: {id:0,label:''},
      evento2: {id:0,label:''},
      evento3: {id:0,label:''},
      evento4: {id:0,label:''},
      evento5: {id:0,label:''},
      evento6: {id:0,label:''},
      categoria:'',
    }
  },
  created() {


    this.$q.loading.show()
    this.$api.get('evento').then(res=>{
      this.$q.loading.hide()
      this.eventos=[{id:0,label: ''}]
      res.data.forEach(r=>{
        r.label=r.nombre
        this.eventos.push(r)
      })
      // console.log(this.eventos)
      this.evento1=this.eventos[0]
      this.evento2=this.eventos[0]
      this.evento3=this.eventos[0]
      this.evento4=this.eventos[0]
      this.evento5=this.eventos[0]
      this.evento6=this.eventos[0]
    })
  },
  methods:{
    edad(fechanac){
      let nacimiento=moment(fechanac)
      let hoy=moment()
      let anios=hoy.diff(nacimiento,"years")
      if (anios>=10 && anios<=14){
        this.categoria="10-14"
      }else if (anios>=15 && anios<=19){
        this.categoria="15-19"
      }else if (anios>=20 && anios<=24){
        this.categoria="20-24"
      }else if (anios>=25 && anios<=29){
        this.categoria="25-29"
      }else if (anios>=30 && anios<=34){
        this.categoria="30-34"
      }else if (anios>=35 && anios<=39){
        this.categoria="35-39"
      }else if (anios>=40 && anios<=44){
        this.categoria="40-44"
      }else if (anios>=45 && anios<=49){
        this.categoria="45-49"
      }else if (anios>=50 && anios<=54){
        this.categoria="50-54"
      }else if (anios>=55 && anios<=59){
        this.categoria="55-59"
      }else if (anios>=60 && anios<=64){
        this.categoria="60-64"
      }else if (anios>=65 && anios<=69){
        this.categoria="25-29"
      }else if (anios>=70 && anios<=74){
        this.categoria="70-74"
      }else if (anios>=75 && anios<=79){
        this.categoria="75-79"
      }else if (anios>=80 && anios<=84){
        this.categoria="80-84"
      }else if (anios>=85 && anios<=89){
        this.categoria="85-89"
      } else if (anios>=90 && anios<=94){
        this.categoria="90-94"
      }else if (anios>=95 && anios<=99){
        this.categoria="95-99"
      }
      return anios
    },
    createRegistro(){
      this.$q.dialog({
        title:"Atencion!",
        message:"Una vez registrado no se podra volver a cambiar a los eventos",
        persistent:true,
        cancel:true,
      }).onOk(()=>{
        // console.log('a')
        this.$q.loading.show()
        this.$api.post('registro',{
          datos:[
            {evento_id:this.evento1.id},
            {evento_id:this.evento2.id},
            {evento_id:this.evento3.id},
            {evento_id:this.evento4.id},
            {evento_id:this.evento5.id},
            {evento_id:this.evento6.id},
          ],
          categoria:this.categoria
        }).then(res=>{
          this.$q.loading.hide()
          // console.log(res.data)
          this.$store.commit('login/verificadotrue')
          this.$q.notify({
            message:"Registrado Correctamente!",
            color:"green",
            position:'top',
            icon:"check"
          })
        })
      })
    }
  },
  computed:{
  }
}
</script>

<style scoped>

</style>
