<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-form @submit.prevent="consulta">
        <div class="row">
          <div class="col-4">
            <q-select dense  outlined label="evento" :options="eventos" v-model="evento" />
          </div>
          <div class="col-4">
            <q-select dense outlined label="edad" :options="edades" v-model="edad"/>
          </div>
          <div class="col-4">
            <q-input type="date" dense outlined label="fecha"  v-model="fecha"/>
          </div>
          <div class="col-12">
            <q-btn type="submit" icon="search" color="info" label="consultar" class="full-width"/>
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <q-table  :columns="columsregistro" :rows="registros" :filter="filter" dense>
        <template v-slot:body-cell-opcion="props">
          <q-td auto-width :props="props">
            <q-btn flat  round icon="add_circle" @click="dialogtiempos=true;registro=props.row" color="positive" />
          </q-td>
        </template>
        <template v-slot:body-cell-nombre="props">
          <q-td auto-width :props="props">
            <div class="text-body2">{{props.row.num}} {{props.row.player.paterno}} <br> {{props.row.player.materno}}<br>{{props.row.player.nombres}}</div>
          </q-td>
        </template>
        <template v-slot:body-cell-tiempo="props">
          <q-td auto-width :props="props">
            <div class="text-body2">{{props.row.dato1}}<br>{{props.row.dato2}}<br>{{props.row.dato3}}<br>{{props.row.dato4}}<br>{{props.row.dato5}}</div>
          </q-td>
        </template>
        <template v-slot:top-right>
          <q-btn label="Registrar" icon="add_circle" color="primary" @click="dialogregistro=true" />
          <q-input dense outlined v-model="filter" placeholder="Buscar"/>
        </template>
      </q-table>
    </div>
  </div>
  <q-dialog full-width v-model="dialogtiempos">
    <q-card>
      <q-card-section class="text-h6">Puntos {{registro.nombre}}</q-card-section>
      <q-separator/>
      <q-card-section>
        <q-form>
          <div class="row">
            <div class="col-12">
              <q-input dense type="time" outlined @update:model-value="updateRegistro1" label="dato1" v-model="registro.dato1" />
              <q-input dense type="time" outlined @update:model-value="updateRegistro2" label="dato2" v-model="registro.dato2" />
              <q-input dense type="time" outlined @update:model-value="updateRegistro3" label="dato3" v-model="registro.dato3" />
              <q-input dense type="time" outlined @update:model-value="updateRegistro4" label="dato4" v-model="registro.dato4" />
              <q-input dense type="time" outlined @update:model-value="updateRegistro5" label="dato5" v-model="registro.dato5" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog full-width v-model="dialogregistro">
    <q-card>
      <q-card-section class="text-subtitle2">
        Evento={{evento.label}}
        Edad={{edad}}
        Fecha={{fecha}}
      </q-card-section>
      <q-separator/>
      <q-card-section>
        <q-form @submit="createRegistro">
          <div class="row">
            <div class="col-12">
              <q-select outlined use-input dense label="Jugador" :options="players" v-model="player" @filter="filterFn" >
                <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      No resultados
                    </q-item-section>
                  </q-item>
                </template>
              </q-select>
            </div>
            <div class="col-12">
              <q-btn color="positive" icon="add_circle" label="Registrar" type="submit" class="full-width" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
import moment from "moment"
import {date} from "quasar";
export default {
  name: `Registro`,
  data(){
    return{
      dialogregistro:false,
      dialogtiempos:false,
      filter:'',
      columsregistro:[
        {name:'opcion',field:'opcion',label:'opcion'},
        // {name:'num',field:'num',label:'num'},
        {name:'nombre',field:'nombre',label:'nombre',align:'left'},
        {name:'categoria',field:'categoria',label:'categoria'},
        {name:'tiempo',field:'tiempo',label:'tiempo'},
        {name:'posicion',field:'posicion',label:'posicion'},
      ],
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      edades:[
        "30-34",
        "35-39",
        "40-44",
        "45-49",
        "50-54",
        "55-59",
        "60-64",
        "65-69",
        "70-74",
        "75-79",
        "80-84",
        "85-89",
      ],
      edad:'30-34',
      eventos:[],
      evento:{},
      players:[],
      players2:[],
      player:{},
      registros:[],
      registro:{},
    }
  },
  created() {
    this.$q.loading.show()
    this.$api.get('player').then(res=>{
      this.players=[]
      res.data.forEach(r=>{
        let nacimiento=moment(r.fechanac);
        let hoy=moment();
        let anios=hoy.diff(nacimiento,"years");
        r.label=anios+' '+r.paterno+' '+r.materno+' '+r.nombres
        this.players.push(r)
      })
      this.players2=this.players
      this.player=this.players[0]
    })
    this.$api.get('evento').then(res=>{
      this.eventos=[]
      res.data.forEach(r=>{
        r.label=r.nombre
        this.eventos.push(r)
      })
      this.evento=this.eventos[0]
      this.consulta()
    })
  },
  methods:{
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.players = this.players2
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.players = this.players2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    createRegistro(){
      this.$q.loading.show()
      this.$api.post('registro',{
        fecha:this.fecha,
        edad:this.edad,
        dato1:"00:00:00",
        dato2:"00:00:00",
        dato3:"00:00:00",
        dato4:"00:00:00",
        dato5:"00:00:00",
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        this.consulta()
        this.dialogregistro=false
      })
    },
    updateRegistro1(dato){
      this.$api.put('registro/'+this.registro.id,{
        fecha:this.fecha,
        edad:this.edad,
        dato1:dato,
        dato2:this.registro.dato2,
        dato3:this.registro.dato3,
        dato4:this.registro.dato4,
        dato5:this.registro.dato5,
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        console.log(res.data)
        // this.consulta()
      })
    },
    updateRegistro2(dato){
      this.$api.put('registro/'+this.registro.id,{
        fecha:this.fecha,
        edad:this.edad,
        dato1:this.registro.dato1,
        dato2:dato,
        dato3:this.registro.dato3,
        dato4:this.registro.dato4,
        dato5:this.registro.dato5,
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        console.log(res.data)
        // this.consulta()
      })
    },
    updateRegistro3(dato){
      this.$api.put('registro/'+this.registro.id,{
        fecha:this.fecha,
        edad:this.edad,
        dato1:this.registro.dato1,
        dato2:this.registro.dato2,
        dato3:dato,
        dato4:this.registro.dato4,
        dato5:this.registro.dato5,
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        console.log(res.data)
        // this.consulta()
      })
    },
    updateRegistro4(dato){
      this.$api.put('registro/'+this.registro.id,{
        fecha:this.fecha,
        edad:this.edad,
        dato1:this.registro.dato1,
        dato2:this.registro.dato2,
        dato3:this.registro.dato3,
        dato4:dato,
        dato5:this.registro.dato5,
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        console.log(res.data)
        // this.consulta()
      })
    },
    updateRegistro5(dato){
      this.$api.put('registro/'+this.registro.id,{
        fecha:this.fecha,
        edad:this.edad,
        dato1:this.registro.dato1,
        dato2:this.registro.dato2,
        dato3:this.registro.dato3,
        dato4:this.registro.dato4,
        dato5:dato,
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        console.log(res.data)
        // this.consulta()
      })
    },
    consulta(){
      this.$q.loading.show()
      this.$api.post('consulta',{fecha:this.fecha,evento_id:this.evento.id,edad:this.edad}).then(res=>{
        console.log(res.data)
        this.registros=[]
        let c=1
        res.data.forEach(r=>{
          r.num=c
          r.nombre=r.player.paterno+' '+r.player.materno+' '+r.player.nombres
          r.categoria=r.evento.nombre
          c++
          this.registros.push(r)
        })
        this.$q.loading.hide()
      })
    }
  }
}
</script>

<style scoped>

</style>
